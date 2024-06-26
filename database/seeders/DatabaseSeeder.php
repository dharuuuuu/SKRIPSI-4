<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionsSeeder::class);
        // $this->call(ProdukSeeder::class);
        // $this->call(ItemSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(CustomerSeeder::class);
    }
}
