<?php

namespace App\Http\Controllers;

use App\Models\PenarikanGaji;
use App\Models\GajiPegawai;
use App\Models\Produk;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Exports\Riwayat_Penarikan_Gaji_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Charts\RiwayatPenarikanGaji\RiwayatPenarikanGajiChart;

class RiwayatPenarikanGajiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('list_riwayat_semua_ajuan', PenarikanGaji::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        // $start_date = $request->input('start_date');
        // $end_date = $request->input('end_date');

        $riwayat_penarikan_gajis = PenarikanGaji::query()
            // ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
            //     $query->whereDate('updated_at', '>=', $start_date)
            //         ->whereDate('updated_at', '<=', $end_date);
            // })
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('user', function ($query) use ($search) {
                        $query->where('nama', 'LIKE', "%{$search}%");
                    });
                });
            })
            ->with('user') 
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();


        return view('gaji.riwayat_penarikan_gaji.index', compact('riwayat_penarikan_gajis', 'search'));
    }


    public function diagram(RiwayatPenarikanGajiChart $penarikan_gaji)
    {
        return view('gaji.riwayat_penarikan_gaji.diagram', [
            'penarikan_gaji' => $penarikan_gaji->build(),
        ]);
    } 

    
    public function show(Request $request, PenarikanGaji $riwayat_penarikan_gaji): View
    {
        $this->authorize('view_riwayat_semua_ajuan', $riwayat_penarikan_gaji);

        $pegawai = GajiPegawai::where('pegawai_id', $riwayat_penarikan_gaji->pegawai_id)->first();

        $detail_gaji_pegawais = DB::table('kegiatans')
            ->join('items', 'kegiatans.item_id', '=', 'items.id')
            ->select(
                'items.id', 
                'items.nama_item', 
                'items.gaji_per_item', 
                DB::raw('SUM(kegiatans.jumlah_kegiatan) as total_jumlah_kegiatan'), 
                DB::raw('SUM(kegiatans.jumlah_kegiatan * CAST(items.gaji_per_item AS DECIMAL(10, 2))) as total_gaji_per_item')
            )
            ->where('kegiatans.user_id', $pegawai->pegawai_id)
            ->where('kegiatans.status_kegiatan', 'Selesai')
            ->whereBetween('kegiatans.updated_at', [$riwayat_penarikan_gaji->mulai_tanggal, $riwayat_penarikan_gaji->akhir_tanggal])   
            ->groupBy('items.id', 'items.nama_item', 'items.gaji_per_item')
            ->get();

        return view('gaji.riwayat_penarikan_gaji.show', compact('riwayat_penarikan_gaji', 'detail_gaji_pegawais'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Penarikan_Gaji_Export_Excel, 'Riwayat Penarikan Gaji (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $riwayat_penarikan_gajis = PenarikanGaji::all();

        $pdf = PDF::loadView('PDF.riwayat_penarikan_gaji', compact('riwayat_penarikan_gajis'))->setPaper('a4', 'landscape');;

        return $pdf->download('Riwayat Penarikan Gaji (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
