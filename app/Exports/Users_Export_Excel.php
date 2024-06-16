<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Users_Export_Excel implements FromCollection, WithHeadings, WithMapping
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
            'Alamat',
            'No Telepon',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Created At',   
            'Updated At'        
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->nama,
            $user->email,
            $user->alamat,
            $user->no_telepon,
            $user->jenis_kelamin,
            optional($user->tanggal_lahir)->format('Y-m-d'),
            $user->created_at,
            $user->updated_at,
        ];
    }

    public function collection()
    {
        return User::all();
    }

    public function title(): string
    {
        return 'User - ' . $this->timestamp;
    }
}
