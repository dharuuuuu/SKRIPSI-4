<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Items_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Gaji Per Item',
            'Deskripsi',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->nama_item,
            $item->gaji_per_item,
            $item->deskripsi_item,
            $item->created_at,
            $item->updated_at,
        ];
    }

    public function collection()
    {
        return Item::all();
    }

    public function title(): string
    {
        return 'Item - ' . $this->timestamp;
    }
}
