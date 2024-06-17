<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Item;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\GajiPerProduk;
use App\Models\GajiPegawai;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KegiatanStoreRequest;
use App\Http\Requests\KegiatanUpdateRequest;
use App\Exports\Kegiatan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class KegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', Kegiatan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $kegiatans = Kegiatan::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('item', function ($query) use ($search) {
                    $query->where('nama_item', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->with('item')
            ->with('user') 
            ->where('status_kegiatan', 'LIKE', 'Belum Ditarik')
            ->where('user_id', 'LIKE', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('transaksi.kegiatan.index', compact('kegiatans', 'search'));
    }

  
    public function create(Request $request): View
    {
        $this->authorize('create', Kegiatan::class);

        $items = Item::pluck('nama_item', 'id');

        return view('transaksi.kegiatan.create', compact('items'));

    }

    
    public function store(KegiatanStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Kegiatan::class);

        $validated = $request->validated();

        $kegiatan = Kegiatan::create($validated);

        $user = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();
        $user->total_gaji_yang_bisa_diajukan += $kegiatan->jumlah_kegiatan * $kegiatan->item->gaji_per_item;
        $user->save();

        return redirect()
            ->route('kegiatan.index', $kegiatan)
            ->withSuccess(__('crud.common.created'));
    }

    
    public function edit(Request $request, Kegiatan $kegiatan): View
    {
        $this->authorize('update', $kegiatan);

        $items = Item::pluck('nama_item', 'id');

        return view('transaksi.kegiatan.edit', compact('kegiatan', 'items'));
    }

    
    public function update(
        KegiatanUpdateRequest $request,
        Kegiatan $kegiatan
    ): RedirectResponse {
        $this->authorize('update', $kegiatan);

        $validated = $request->validated();

        $user = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();
        $user->total_gaji_yang_bisa_diajukan -= $kegiatan->jumlah_kegiatan * $kegiatan->item->gaji_per_item;
        $user->save();

        $kegiatan->update($validated);

        $user = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();
        $user->total_gaji_yang_bisa_diajukan += $kegiatan->jumlah_kegiatan * $kegiatan->item->gaji_per_item;
        $user->save();

        return redirect()
            ->route('kegiatan.edit', $kegiatan)
            ->withSuccess(__('crud.common.saved'));
    }


    public function show(Request $request, Kegiatan $kegiatan): View
    {
        $this->authorize('view', $kegiatan);

        $kegiatans = Kegiatan::where('id', $kegiatan->id)->get();

        return view('transaksi.kegiatan.show', compact('kegiatan', 'kegiatans'));
    }

    public function destroy(
        Request $request,
        Kegiatan $kegiatan
    ): RedirectResponse {

        $this->authorize('delete', $kegiatan);

        $user = GajiPegawai::where('pegawai_id', Auth::user()->id)->first();
        $user->total_gaji_yang_bisa_diajukan -= $kegiatan->jumlah_kegiatan * $kegiatan->item->gaji_per_item;
        $user->save();
        
        $kegiatan->delete();        

        return redirect()
            ->route('kegiatan.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
