<?php

namespace App\Http\Controllers;

use App\Models\RiwayatStokProduk;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\RiwayatStokProdukStoreRequest;
use App\Exports\RiwayatStokProduk_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\StokMasuk\StokMasukChart;

class RiwayatStokProdukController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', RiwayatStokProduk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $riwayat_stok_produks = RiwayatStokProduk::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'LIKE', "%{$search}%");
                });
            })
            ->with('produk')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('transaksi.riwayat_stok_produk.index', compact('riwayat_stok_produks', 'search'));
    }


    public function diagram(StokMasukChart $stok_masuk)
    {
        return view('transaksi.riwayat_stok_produk.diagram', [
            'stok_masuk' => $stok_masuk->build(),
        ]);
    } 


    public function create(Request $request): View
    {
        $this->authorize('create', RiwayatStokProduk::class);

        $produks = Produk::pluck('nama_produk', 'id');

        return view('transaksi.riwayat_stok_produk.create', compact('produks'));
    }

  
    public function store(RiwayatStokProdukStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', RiwayatStokProduk::class);

        $validated = $request->validated();

        $riwayat_stok_produk = RiwayatStokProduk::create($validated);


        $stok_produk = Produk::where('id', $request->id_produk)->first();
        $newValue = $stok_produk->stok_produk + $request->stok_masuk;
        $stok_produk->update(['stok_produk' => $newValue]);

        return redirect()
            ->route('riwayat_stok_produk.index')
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, RiwayatStokProduk $riwayat_stok_produk): View
    {
        $this->authorize('view', $riwayat_stok_produk);

        return view('transaksi.riwayat_stok_produk.show', compact('riwayat_stok_produk'));
    }

    public function export_excel()
    {
        return Excel::download(new RiwayatStokProduk_Export_Excel, 'Riwayat Stok Produk - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $riwayat_stok_produks = RiwayatStokProduk::all();

        $pdf = PDF::loadView('PDF.riwayat_stok_produk', compact('riwayat_stok_produks'))->setPaper('a4', 'landscape');;

        return $pdf->download('Riwayat Stok Produk - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
