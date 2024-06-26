<?php

namespace App\Exports;

use App\Models\Kegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Auth;

class Riwayat_Kegiatan_Admin_Export_Excel implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $timestamp;

    public function __construct()
    {
        $this->timestamp = now()->format('Y-m-d_H-i-s');
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kegiatan',
            'Nama Pegawai',
            'Jumlah',
            'Catatan',   
            'Kegiatan Dibuat'            
        ];
    }

    public function map($kegiatan): array
    {
        return [
            $kegiatan->id,
            $kegiatan->item->nama_item,
            $kegiatan->user->nama,
            $kegiatan->jumlah_kegiatan,
            $kegiatan->catatan,
            $kegiatan->kegiatan_dibuat,
        ];
    }

    public function collection()
    {
        return Kegiatan::all();
    }

    public function title(): string
    {
        return 'Riwayat Kegiatan (Semua) - ' . $this->timestamp;
    }
}
