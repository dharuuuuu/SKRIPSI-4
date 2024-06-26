<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PesananStoreRequest;
use App\Http\Requests\PesananUpdateRequest;
use App\Exports\Pesanan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\Pesanan\PemasukanChart;
use App\Charts\Pesanan\ProdukTerlarisChart;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Invoice::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $customer_input = $request->input('customer_input');
        $customers = User::role('Sales')->pluck('nama', 'id');

        $invoices = Invoice::query()
        ->when($customer_input, function ($query) use ($customer_input) {
            $query->where('customer_id', $customer_input);
        })
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('updated_at', '>=', $start_date)
                    ->whereDate('updated_at', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%")
                        ->orWhere('invoice', 'LIKE', "%{$search}%");
                });
            });
            
        if (auth()->user()->hasRole('Sales')) {
            $invoices->where('customer_id', Auth::user()->id);
        }
    
        $invoices = $invoices->with('user')->latest()
                                ->paginate($paginate)
                                ->withQueryString();

        return view('transaksi.invoice.index', compact('invoices', 'search', 'customers'));
    }


    public function diagram(PemasukanChart $pemasukan, ProdukTerlarisChart $produk_terlaris)
    {
        return view('transaksi.invoice.diagram', [
            'pemasukan' => $pemasukan->build(),
            'produk_terlaris' => $produk_terlaris->build()
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create', Invoice::class);

        $produks = Produk::all();
        $users = User::role('Sales')->pluck('nama', 'id');

        $create = 'create';

        return view('transaksi.invoice.create', compact('produks', 'create', 'users'));
    }


    public function store(PesananStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Invoice::class);

        $data = $request->validated();

        $todayInvoiceCount = Invoice::whereDate('created_at', today())->count();

        $invoice = new Invoice();
        $invoice->customer_id = $request->customer_id;  
        $invoice->invoice = 'IVC' . '-' . date('Ymd') . '-' . ($todayInvoiceCount + 1);
        $invoice->tagihan_sebelumnya = $invoice->user->tagihan;
        $invoice->save();

        foreach ($data['produk_id'] as $index => $produk_id) {
            $produk = Produk::find($produk_id);
            $jumlah_pesanan = $data['jumlah_pesanan'][$index] ?? null;

            if ($produk->stok_produk < $jumlah_pesanan) {
                $invoice->delete();

                return redirect()
                    ->route('invoice.create')
                    ->with('error', 'Stok produk ' . $produk->nama_produk . ' tidak mencukupi.');
            }

            $pesanan = new Pesanan();
            $pesanan->invoice_id = $invoice->id;
            $pesanan->produk_id = $produk_id;
            $pesanan->harga = $data['harga'][$index] ?? null;
            $pesanan->jumlah_pesanan = $jumlah_pesanan;
            $pesanan->save();

            $produk->stok_produk -= $jumlah_pesanan;
            $produk->save();
        }

        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();
        $total_subtotal = 0;

        foreach($pesanans as $index => $pesanan)
        {
            if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
            {
                    $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                    $total_subtotal += $subtotal;
            }
        }

        $invoice->user->tagihan += $total_subtotal;
        $invoice->user->save();
        
        $user = User::where('id', $request->customer_id)->first();
        $invoice->tagihan_total = $user->tagihan;
        $invoice->sub_total = $total_subtotal;
        $invoice->save();

        return redirect()
            ->route('invoice.edit', $invoice)
            ->with('success', 'Invoice created successfully.');
    }


    public function show(Request $request, Invoice $invoice): View
    {
        $this->authorize('view', $invoice);
        
        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();

        return view('transaksi.invoice.show', compact('invoice', 'pesanans'));
    }


    public function edit(Request $request, Invoice $invoice): View
    {
        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();

        return view('transaksi.invoice.edit', compact('invoice', 'pesanans'));
    }

    
    public function update(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {

        $validatedData = $request->validate([
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        $jumlah_bayar = $validatedData['jumlah_bayar'];

        // Update the customer's bill
        $user = $invoice->user;
        $user->tagihan -= $jumlah_bayar;

        // Ensure the bill doesn't go negative
        if ($user->tagihan < 0) {
            $user->tagihan = 0;
        }

        $user->save();

        $invoice->jumlah_bayar = $jumlah_bayar;
        $invoice->tagihan_sisa = $invoice->user->tagihan;
        $invoice->save();

        return redirect()
            ->route('invoice.index')
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        Invoice $invoice
    ): RedirectResponse {
        $this->authorize('delete', $invoice);

        $pesanans = Pesanan::where('invoice_id', $invoice->id)
                ->get();
        
        foreach ($pesanans as $index => $pesanan) {
            $produk = Produk::find($pesanan->produk_id);

            $produk->stok_produk = $produk->stok_produk + $pesanan->jumlah_pesanan;
            $produk->save();
        }

        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();
        $total_subtotal = 0;

        foreach($pesanans as $index => $pesanan)
        {
            if (isset($pesanan->jumlah_pesanan) && isset($pesanan->harga))
            {
                    $subtotal = $pesanan->jumlah_pesanan * $pesanan->harga;
                    $total_subtotal += $subtotal;
            }
        }

        $invoice->user->tagihan -= $total_subtotal;
        $invoice->user->save();
        $invoice->user->tagihan += $invoice->jumlah_bayar;
        $invoice->user->save();

        $invoice->delete();

        return redirect()
            ->route('invoice.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Pesanan_Export_Excel, 'Pesanan - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }
    

    public function export_pdf()
    {
        if (auth()->user()->hasRole('Sales')) {
            $invoices = Invoice::where('customer_id', Auth::user()->id)->get();
        }
        else {
            $invoices = Invoice::all();
        }

        $pdf = PDF::loadView('PDF.pesanan', compact('invoices'))->setPaper('a4', 'landscape');;

        return $pdf->download('Pesanan - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }


    public function invoice_pdf($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        $pesanans = Pesanan::where('invoice_id', $invoice->id)->get();

        $pdf = PDF::loadView('PDF.invoice', compact('invoice', 'pesanans'))->setPaper('a4', 'potrait');

        return $pdf->download('Invoice :  - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
