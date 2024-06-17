<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProdukStoreRequest;
use App\Http\Requests\ProdukUpdateRequest;
use App\Exports\Produks_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Charts\Produk\StokChart;

class ProdukController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Produk::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $produks = Produk::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_produk', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.produks.index', compact('produks', 'search'));
    }


    public function diagram(StokChart $stok)
    {
        return view('masterdata.produks.diagram', [
            'stok' => $stok->build(),
        ]);
    } 

    
    public function create(Request $request): View
    {
        $this->authorize('create', Produk::class);

        return view('masterdata.produks.create');
    }


    public function store(ProdukStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Produk::class);

        $validated = $request->validated();

        $produk = Produk::create($validated);

        return redirect()
            ->route('produks.index', $produk)
            ->withSuccess(__('crud.common.created'));
    }


    public function show(Request $request, Produk $produk): View
    {
        $this->authorize('view', $produk);

        return view('masterdata.produks.show', compact('produk'));
    }


    public function edit(Request $request, Produk $produk): View
    {
        $this->authorize('update', $produk);

        return view('masterdata.produks.edit', compact('produk'));
    }


    public function update(
        ProdukUpdateRequest $request,
        Produk $produk
    ): RedirectResponse {
        $this->authorize('update', $produk);

        $validated = $request->validated();

        $produk->update($validated);

        return redirect()
            ->route('produks.edit', $produk)
            ->withSuccess(__('crud.common.saved'));
    }


    public function destroy(
        Request $request,
        Produk $produk
    ): RedirectResponse {
        $this->authorize('delete', $produk);
        
        $produk->delete();

        return redirect()
            ->route('produks.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Produks_Export_Excel, 'Produks - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $produks = Produk::all();

        $pdf = PDF::loadView('PDF.produks', compact('produks'))->setPaper('a4', 'landscape');;

        return $pdf->download('Produks - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
