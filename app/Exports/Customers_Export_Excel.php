<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Customers_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Email',
            'No Telepon',
            'Alamat',
            'Tagihan',
            'Created At',   
            'Updated At'            
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->nama,
            $customer->email,
            $customer->no_telepon,
            $customer->alamat,
            $customer->tagihan,
            $customer->created_at,
            $customer->updated_at,
        ];
    }

    public function collection()
    {
        return Customer::all();
    }

    public function title(): string
    {
        return 'Customer - ' . $this->timestamp;
    }
}
