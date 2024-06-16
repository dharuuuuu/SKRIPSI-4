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
use App\Exports\Riwayat_Kegiatan_Pegawai_Export_Excel;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Charts\RiwayatKegiatan\KegiatanPegawaiChart;

class RiwayatKegiatanPegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('list_riwayat_kegiatan_pegawai', Kegiatan::class);

        $paginate = max(10, intval($request->input('paginate', 10)));
        $search = $request->get('search', '');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $kegiatans = Kegiatan::query()
            ->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereDate('updated_at', '>=', $start_date)
                    ->whereDate('updated_at', '<=', $end_date);
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
            ->where('user_id', 'LIKE', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->latest()
            ->paginate($paginate)
            ->withQueryString();


        return view('transaksi.riwayat_kegiatan_pegawai.index', compact('kegiatans', 'search', 'start_date', 'end_date'));
    }


    public function diagram(KegiatanPegawaiChart $kegiatan)
    {
        return view('transaksi.riwayat_kegiatan_pegawai.diagram', [
            'kegiatan' => $kegiatan->build(),
        ]);
    } 

    
    public function show(Request $request, Kegiatan $riwayat_kegiatan_pegawai): View
    {
        $this->authorize('view_riwayat_kegiatan_pegawai', $riwayat_kegiatan_pegawai);

        return view('transaksi.riwayat_kegiatan_pegawai.show', compact('riwayat_kegiatan_pegawai'));
    }


    public function export_excel()
    {
        return Excel::download(new Riwayat_Kegiatan_Pegawai_Export_Excel, 'Riwayat Kegiatan ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.xlsx');
    }

    public function export_pdf()
    {
        $kegiatans = Kegiatan::where('user_id', 'LIKE', Auth::user()->id)->get();

        $pdf = PDF::loadView('PDF.riwayat_kegiatan_pegawai', compact('kegiatans'))->setPaper('a4', 'landscape');;

        return $pdf->download('Kegiatan ( ' . Auth::user()->nama . ' ) - ' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
