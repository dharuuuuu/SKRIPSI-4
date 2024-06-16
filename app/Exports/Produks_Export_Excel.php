<?php

namespace App\Exports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Produks_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Nama',
            'Stok',
            'Biaya 1',
            'Biaya 2',
            'Biaya 3',
            'Biaya 4',
            'Deskripsi',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($produk): array
    {
        return [
            $produk->id,
            $produk->nama_produk,
            $produk->stok_produk,
            $produk->harga_produk_1,
            $produk->harga_produk_2,
            $produk->harga_produk_3,
            $produk->harga_produk_4,
            $produk->deskripsi_produk,
            $produk->created_at,
            $produk->updated_at,
        ];
    }

    public function collection()
    {
        return Produk::all();
    }

    public function title(): string
    {
        return 'Produk - ' . $this->timestamp;
    }
}
