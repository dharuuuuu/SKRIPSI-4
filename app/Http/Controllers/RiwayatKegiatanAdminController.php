<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Item;
use App\Models\User;
use App\Models\Pesanan;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\KegiatanStoreRequest;
use App\Http\Requests\KegiatanUpdateRequest;
use App\Exports\Riwayat_Kegiatan_Admin_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Charts\RiwayatKegiatan\KegiatanAdminChart;

class RiwayatKegiatanAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('list_riwayat_kegiatan_admin', Kegiatan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $kegiatans = Kegiatan::query()
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('tanggal_selesai', '>=', $start_date)
                    ->whereDate('tanggal_selesai', '<=', $end_date);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('item', function ($query) use ($search) {
                        $query->where('nama_item', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('nama', 'LIKE', "%{$search}%");
                    });
                });
            })
            ->with('item')
            ->with('user') 
            ->where('status_kegiatan', 'LIKE', 'Sudah Ditarik')
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();


        return view('transaksi.riwayat_kegiatan_admin.index', compact('kegiatans', 'search', 'start_date', 'end_date'));
    }


    public function diagram(KegiatanAdminChart $kegiatan)
    {
        return view('transaksi.riwayat_kegiatan_admin.diagram', [
            'kegiatan' => $kegiatan->build(),
        ]);
    } 

    
    public function show(Request $request, Kegiatan $riwayat_kegiatan_admin): View
    {
        $this->authorize('view_riwayat_kegiatan_admin', $riwayat_kegiatan_admin);

        $kegiatans = Kegiatan::where('id', $riwayat_kegiatan_admin->id)->get();

        return view('transaksi.riwayat_kegiatan_admin.show', compact('riwayat_kegiatan_admin', 'kegiatans'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Kegiatan_Admin_Export_Excel, 'Riwayat Kegiatan (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $kegiatans = Kegiatan::all();

        $pdf = PDF::loadView('PDF.riwayat_kegiatan_admin', compact('kegiatans'))->setPaper('a4', 'landscape');;

        return $pdf->download('Kegiatan (Semua) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
