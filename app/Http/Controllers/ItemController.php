<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ItemStoreRequest;
use App\Http\Requests\ItemUpdateRequest;
use App\Exports\Items_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Item::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $items = Item::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_item', 'LIKE', "%{$search}%")
                    ->orWhere('gaji_per_item', 'LIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('masterdata.items.index', compact('items', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Item::class);

        return view('masterdata.items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Item::class);

        $validated = $request->validated();

        $item = Item::create($validated);

        return redirect()
            ->route('items.index')
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Item $item): View
    {
        $this->authorize('view', $item);

        return view('masterdata.items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Item $item): View
    {
        $this->authorize('update', $item);

        return view('masterdata.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ItemUpdateRequest $request,
        Item $item
    ): RedirectResponse {
        $this->authorize('update', $item);

        $validated = $request->validated();

        $item->update($validated);

        return redirect()
            ->route('items.edit', $item)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Item $item
    ): RedirectResponse {
        $this->authorize('delete', $item);
        $item->delete();

        return redirect()
            ->route('items.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function export_excel()
    {
        return Excel::download(new Items_Export_Excel, 'Items - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $items = Item::all();

        $pdf = PDF::loadView('PDF.items', compact('items'))->setPaper('a4', 'landscape');;

        return $pdf->download('Items - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
