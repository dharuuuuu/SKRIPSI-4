<?php

namespace App\Http\Controllers;

use App\Models\PenarikanGaji;
use App\Models\Produk;
use App\Models\GajiPegawai;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PengajuanPenarikanGajiUpdateRequest;
use App\Exports\Pesanan_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KonfirmasiPenarikanGajiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('list_ajuan', PenarikanGaji::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $konfirmasi_ajuans = PenarikanGaji::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->where('status', 'Diajukan')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('gaji.konfirmasi_penarikan_gaji.index', compact('konfirmasi_ajuans', 'search'));
    }

    public function show(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): View
    {
        $this->authorize('view', $konfirmasi_penarikan_gaji);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('items', 'kegiatans.item_id', '=', 'items.id')
            ->select(
                'items.id', 
                'items.nama_item', 
                'items.gaji_per_item', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(items.gaji_per_item AS DECIMAL(10, 2))) as total_gaji_per_item')
            )
            ->where('kegiatans.user_id', $konfirmasi_penarikan_gaji->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Selesai')
            ->whereBetween('kegiatans.updated_at', [$konfirmasi_penarikan_gaji->mulai_tanggal, $konfirmasi_penarikan_gaji->akhir_tanggal])  
            ->groupBy('items.id', 'items.nama_item', 'items.gaji_per_item')
            ->get(); 

        return view('gaji.konfirmasi_penarikan_gaji.show', compact('konfirmasi_penarikan_gaji', 'detail_gaji_pegawais'));
    }


    public function terima_ajuan(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): RedirectResponse 
    {
        $this->authorize('terima_ajuan', $konfirmasi_penarikan_gaji);
    
        // dd($konfirmasi_penarikan_gaji);
        $konfirmasi_penarikan_gaji->status = 'Diterima';
        $konfirmasi_penarikan_gaji->gaji_diberikan = now();
        $konfirmasi_penarikan_gaji->save();

        $gaji_pegawai = GajiPegawai::where('pegawai_id', $konfirmasi_penarikan_gaji->pegawai_id)->first();
        $gaji_pegawai->terhitung_tanggal = now();
        $gaji_pegawai->total_gaji_yang_bisa_diajukan = 0;
        $gaji_pegawai->save();
    
        return redirect()
            ->route('konfirmasi_penarikan_gaji.index')
            ->withSuccess(__('Berhasil menerima ajuan'));
    }

    public function tolak_ajuan(Request $request, PenarikanGaji $konfirmasi_penarikan_gaji): RedirectResponse 
    {
        $this->authorize('tolak_ajuan', $konfirmasi_penarikan_gaji);
        // dd($konfirmasi_penarikan_gaji);
    
        $konfirmasi_penarikan_gaji->status = 'Ditolak';
        $konfirmasi_penarikan_gaji->save();
    
        return redirect()
            ->route('konfirmasi_penarikan_gaji.index')
            ->withSuccess(__('Berhasil menolak ajuan'));
    }
}
