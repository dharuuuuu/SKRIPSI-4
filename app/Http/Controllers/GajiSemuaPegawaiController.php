<?php

namespace App\Http\Controllers;

use App\Models\GajiPegawai;
use App\Models\Kegiatan;
use App\Models\Pesanan;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Gaji_Semua_Pegawai_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Charts\GajiPegawai\GajiChart;


class GajiSemuaPegawaiController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('view-any', GajiPegawai::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');

        $gaji_semua_pegawais = GajiPegawai::query()
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($query) use ($search) {
                    $query->where('nama', 'LIKE', "%{$search}%");
                });
            })
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();

        return view('gaji.gaji_semua_pegawai.index', compact('gaji_semua_pegawais', 'search'));
    }


    public function diagram(GajiChart $gaji)
    {
        return view('gaji.gaji_semua_pegawai.diagram', [
            'gaji' => $gaji->build(),
        ]);
    } 

    
    public function show(Request $request, GajiPegawai $gaji_semua_pegawai): View
    {
        $this->authorize('view', $gaji_semua_pegawai);

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('items', 'kegiatans.item_id', '=', 'items.id')
            ->select(
                'items.id', 
                'items.nama_item', 
                'items.gaji_per_item', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(items.gaji_per_item AS DECIMAL(10, 2))) as total_gaji_per_item')
            )
            ->where('kegiatans.user_id', $gaji_semua_pegawai->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Belum Ditarik')
            ->whereBetween('kegiatans.kegiatan_dibuat', [$gaji_semua_pegawai->terhitung_tanggal, now()])   
            ->groupBy('items.id', 'items.nama_item', 'items.gaji_per_item')
            ->get(); 
        
        return view('gaji.gaji_semua_pegawai.show', compact('gaji_semua_pegawai', 'detail_gaji_pegawais'));
    }

    
    public function export_excel()
    {
        return Excel::download(new Gaji_Semua_Pegawai_Export_Excel, 'Gaji Semua Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $gaji_semua_pegawais = GajiPegawai::all();

        $pdf = PDF::loadView('PDF.gaji_semua_pegawai', compact('gaji_semua_pegawais'))->setPaper('a4', 'potrait');;

        return $pdf->download('Gaji Semua Pegawai - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
