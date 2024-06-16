<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::factory()
        //     ->count(25)
        //     ->create();

        $admin = User::create([
            'nama' => 'Admin',
            'email' => 'admin@admin.com',
            'alamat' => 'abc',
            'no_telepon' => 'abc',
            'password' => \Hash::make('admin'),
            'jenis_kelamin' => \Arr::random(['Laki-Laki', 'Perempuan']),
            'tanggal_lahir' => now(),
        ]);

        $admin->assignRole('Admin');

        $sales = User::create([
            'nama' => 'Sales',
            'email' => 'sales@sales.com',
            'alamat' => 'abc',
            'no_telepon' => 'abc',
            'password' => \Hash::make('sales'),
            'jenis_kelamin' => \Arr::random(['Laki-Laki', 'Perempuan']),
            'tanggal_lahir' => now(),
        ]);

        $sales->assignRole('Sales');

        $pegawai = User::create([
            'nama' => 'Pegawai',
            'email' => 'pegawai@pegawai.com',
            'alamat' => 'abc',
            'no_telepon' => 'abc',
            'password' => \Hash::make('pegawai'),
            'jenis_kelamin' => \Arr::random(['Laki-Laki', 'Perempuan']),
            'tanggal_lahir' => now(),
        ]);

        $pegawai->assignRole('pegawai');
    }
}
