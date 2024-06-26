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

        $permissions = [
            'admin' => [
                'list admin',
                'view admin',
                'create admin',
                'update admin',
                'delete admin',
            ],
            'pegawai' => [
                'list pegawai',
                'view pegawai',
                'create pegawai',
                'update pegawai',
                'delete pegawai',
            ],
            'sales' => [
                'list sales',
                'view sales',
                'create sales',
                'update sales',
                'delete sales',
            ],
            'items' => [
                'list items',
                'view items',
                'create items',
                'update items',
                'delete items',
            ],
            'produk' => [
                'list produk',
                'view produk',
                'create produk',
                'update produk',
                'delete produk',
            ],
            'stok_masuk' => [
                'list riwayat stok produk',
                'view riwayat stok produk',
                'create riwayat stok produk',
            ],
            'pesanan' => [
                'list pesanan',
                'view pesanan',
                'create pesanan',
                'delete pesanan',
            ],
            'kegiatan' => [
                'list kegiatan',
                'view kegiatan',
                'create kegiatan',
                'delete kegiatan',
                'update kegiatan',
            ],
            'riwayat_kegiatan_admin' => [
                'list riwayat kegiatan admin',
                'view riwayat kegiatan admin',
            ],
            'riwayat_kegiatan_pegawai' => [
                'list riwayat kegiatan pegawai',
                'view riwayat kegiatan pegawai',
            ],
            'gaji' => [
                'list gaji semua pegawai',
                'view gaji semua pegawai',
            ],
            'pengajuan_penarikan_gaji' => [
                'list pengajuan penarikan gaji',
                'view pengajuan penarikan gaji',
                'create pengajuan penarikan gaji',
                'delete pengajuan penarikan gaji',
            ],
            'konfirmasi_penarikan_gaji' => [
                'list konfirmasi penarikan gaji',
                'terima ajuan penarikan gaji',
                'tolak ajuan penarikan gaji',
            ],
            'riwayat_semua_ajuan' => [
                'list riwayat semua ajuan',
                'view riwayat semua ajuan',
            ],
            'roles' => [
                'list roles',
                'view roles',
                'create roles',
                'update roles',
                'delete roles',
            ],
            'permissions' => [
                'list permissions',
                'view permissions',
                'create permissions',
                'update permissions',
                'delete permissions',
            ],
        ];

        // Create permissions
        foreach ($permissions as $group => $perms) {
            foreach ($perms as $perm) {
                Permission::create(['name' => $perm]);
            }
        }

        // Assign all permissions to Admin role
        $admin_permissions = Permission::whereIn('name', array_merge(
            $permissions['admin'],
            $permissions['pegawai'],
            $permissions['sales'],
            $permissions['items'],
            $permissions['produk'],
            $permissions['stok_masuk'],
            $permissions['pesanan'],
            $permissions['riwayat_kegiatan_admin'],
            $permissions['gaji'],
            $permissions['konfirmasi_penarikan_gaji'],
            $permissions['riwayat_semua_ajuan'],
            $permissions['roles'],
            $permissions['permissions'],
        ))->get();
        $admin_role = Role::create(['name' => 'Admin']);
        $admin_role->givePermissionTo($admin_permissions);

        // Assign specific permissions to Pegawai role
        $pegawai_permissions = Permission::whereIn('name', array_merge(
            $permissions['kegiatan'],
            $permissions['riwayat_kegiatan_pegawai'],
            $permissions['pengajuan_penarikan_gaji']
        ))->get();
        $pegawai_role = Role::create(['name' => 'Pegawai']);
        $pegawai_role->givePermissionTo($pegawai_permissions);

        // Assign specific permissions to Sales role
        $sales_permissions = Permission::whereIn('name', [
            'list pesanan',
            'view pesanan'
        ])->get();
        $sales_role = Role::create(['name' => 'Sales']);
        $sales_role->givePermissionTo($sales_permissions);
    }
}
