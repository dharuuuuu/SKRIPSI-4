<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'list pesanan']);
        Permission::create(['name' => 'view pesanan']);
        Permission::create(['name' => 'create pesanan']);
        Permission::create(['name' => 'delete pesanan']);

        Permission::create(['name' => 'list produk']);
        Permission::create(['name' => 'view produk']);
        Permission::create(['name' => 'create produk']);
        Permission::create(['name' => 'update produk']);
        Permission::create(['name' => 'delete produk']);

        Permission::create(['name' => 'list items']);
        Permission::create(['name' => 'view items']);
        Permission::create(['name' => 'create items']);
        Permission::create(['name' => 'update items']);
        Permission::create(['name' => 'delete items']);

        Permission::create(['name' => 'list customers']);
        Permission::create(['name' => 'view customers']);
        Permission::create(['name' => 'create customers']);
        Permission::create(['name' => 'update customers']);
        Permission::create(['name' => 'delete customers']);

        Permission::create(['name' => 'list riwayat stok produk']);
        Permission::create(['name' => 'view riwayat stok produk']);
        Permission::create(['name' => 'create riwayat stok produk']);

        Permission::create(['name' => 'list kegiatan']);
        Permission::create(['name' => 'view kegiatan']);
        Permission::create(['name' => 'create kegiatan']);
        Permission::create(['name' => 'delete kegiatan']);
        Permission::create(['name' => 'update kegiatan']);
        Permission::create(['name' => 'selesaikan kegiatan']);

        Permission::create(['name' => 'list riwayat kegiatan pegawai']);
        Permission::create(['name' => 'view riwayat kegiatan pegawai']);
        Permission::create(['name' => 'list riwayat kegiatan admin']);
        Permission::create(['name' => 'view riwayat kegiatan admin']);
        
        Permission::create(['name' => 'list gaji semua pegawai']);
        Permission::create(['name' => 'view gaji semua pegawai']);

        Permission::create(['name' => 'list pengajuan penarikan gaji']);
        Permission::create(['name' => 'view pengajuan penarikan gaji']);
        Permission::create(['name' => 'create pengajuan penarikan gaji']);
        Permission::create(['name' => 'delete pengajuan penarikan gaji']);

        Permission::create(['name' => 'list konfirmasi penarikan gaji']);
        Permission::create(['name' => 'terima ajuan penarikan gaji']);
        Permission::create(['name' => 'tolak ajuan penarikan gaji']);

        Permission::create(['name' => 'list riwayat semua ajuan']);
        Permission::create(['name' => 'view riwayat semua ajuan']);

        // Create sales role and assign existing permissions
        $currentPermissions = Permission::all();
        $salesRole = Role::create(['name' => 'Sales']);
        $salesRole->givePermissionTo($currentPermissions);

        // Create pergawai role and assign existing permissions
        $pegawaiRole = Role::create(['name' => 'Pegawai']);
        $pegawaiRole->givePermissionTo($currentPermissions);

        // Create admin exclusive permissions
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

        Permission::create(['name' => 'list permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

        Permission::create(['name' => 'list admin']);
        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'create admin']);
        Permission::create(['name' => 'update admin']);
        Permission::create(['name' => 'delete admin']);

        Permission::create(['name' => 'list pegawai']);
        Permission::create(['name' => 'view pegawai']);
        Permission::create(['name' => 'create pegawai']);
        Permission::create(['name' => 'update pegawai']);
        Permission::create(['name' => 'delete pegawai']);

        Permission::create(['name' => 'list sales']);
        Permission::create(['name' => 'view sales']);
        Permission::create(['name' => 'create sales']);
        Permission::create(['name' => 'update sales']);
        Permission::create(['name' => 'delete sales']);
        
        // Create admin role and assign all permissions
        $allPermissions = Permission::all();
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo($allPermissions);
    }
}
