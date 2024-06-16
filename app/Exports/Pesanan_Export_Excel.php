<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Pesanan_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Invoice',
            'Nama Customer',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->id,
            $invoice->invoice,
            $invoice->customer->nama,
            $invoice->created_at,
            $invoice->updated_at,
        ];
    }

    public function collection()
    {
        return Invoice::all();
    }

    public function title(): string
    {
        return 'Invoice - ' . $this->timestamp;
    }
}
