<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RiwayatStokProdukController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KonfirmasiPesananController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\RiwayatKegiatanPegawaiController;
use App\Http\Controllers\RiwayatKegiatanAdminController;
use App\Http\Controllers\GajiPerProdukController;
use App\Http\Controllers\GajiSemuaPegawaiController;
use App\Http\Controllers\PengajuanPenarikanGajiController;
use App\Http\Controllers\KonfirmasiPenarikanGajiController;
use App\Http\Controllers\RiwayatPenarikanGajiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/menu', function () {
        return view('menu');
    })
    ->name('menu');

Route::prefix('/')
    ->middleware(['auth:sanctum', 'verified'])
    ->group(function () {

        // export admin
        Route::get('/admin/export_excel', [AdminController::class, 'export_excel'])->name('admin.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list admin']);
        Route::get('/admin/export_pdf', [AdminController::class, 'export_pdf'])->name('admin.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list admin']);

        // export pegawai
        Route::get('/pegawai/export_excel', [PegawaiController::class, 'export_excel'])->name('pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);
        Route::get('/pegawai/export_pdf', [PegawaiController::class, 'export_pdf'])->name('pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);

        // export sales
        Route::get('/sales/export_excel', [SalesController::class, 'export_excel'])->name('sales.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list sales']);
        Route::get('/sales/export_pdf', [SalesController::class, 'export_pdf'])->name('sales.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list sales']);

        // export items
        Route::get('/items/export_excel', [ItemController::class, 'export_excel'])->name('items.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list items']);
        Route::get('/items/export_pdf', [ItemController::class, 'export_pdf'])->name('items.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list items']);

        // export produks
        Route::get('/produks/export_excel', [ProdukController::class, 'export_excel'])->name('produks.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list produk']);
        Route::get('/produks/export_pdf', [ProdukController::class, 'export_pdf'])->name('produks.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list produk']);

        // export riwayat stok produk
        Route::get('/riwayat_stok_produk/export_excel', [RiwayatStokProdukController::class, 'export_excel'])->name('riwayat_stok_produk.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);
        Route::get('/riwayat_stok_produk/export_pdf', [RiwayatStokProdukController::class, 'export_pdf'])->name('riwayat_stok_produk.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);

        // export pesanan
        Route::get('/pesanan/export_excel', [PesananController::class, 'export_excel'])->name('pesanan.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/pesanan/export_pdf', [PesananController::class, 'export_pdf'])->name('pesanan.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/pesanan/invoice_pdf/{invoice_id}', [PesananController::class, 'invoice_pdf'])->name('pesanan.invoice_pdf')->middleware(['auth', 'verified', 'role_or_permission:view pesanan']);

        // export roles
        Route::get('/roles/export_excel', [RoleController::class, 'export_excel'])->name('roles.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list roles']);
        Route::get('/roles/export_pdf', [RoleController::class, 'export_pdf'])->name('roles.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list roles']);

        // export permissions
        Route::get('/permissions/export_excel', [PermissionController::class, 'export_excel'])->name('permissions.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list permissions']);
        Route::get('/permissions/export_pdf', [PermissionController::class, 'export_pdf'])->name('permissions.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list permissions']);

        // export riwayat kegiatan pegawai
        Route::get('/riwayat_kegiatan_pegawai/export_excel', [RiwayatKegiatanPegawaiController::class, 'export_excel'])->name('riwayat_kegiatan_pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);
        Route::get('/riwayat_kegiatan_pegawai/export_pdf', [RiwayatKegiatanPegawaiController::class, 'export_pdf'])->name('riwayat_kegiatan_pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);

        // export riwayat kegiatan admin
        Route::get('/riwayat_kegiatan_admin/export_excel', [RiwayatKegiatanAdminController::class, 'export_excel'])->name('riwayat_kegiatan_admin.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);
        Route::get('/riwayat_kegiatan_admin/export_pdf', [RiwayatKegiatanAdminController::class, 'export_pdf'])->name('riwayat_kegiatan_admin.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);

        // export gaji per produk
        Route::get('/gaji_per_produk/export_excel', [GajiPerProdukController::class, 'export_excel'])->name('gaji_per_produk.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list gaji per produk']);
        Route::get('/gaji_per_produk/export_pdf', [GajiPerProdukController::class, 'export_pdf'])->name('gaji_per_produk.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list gaji per produk']);

        // export gaji semua pegawai
        Route::get('/gaji_semua_pegawai/export_excel', [GajiSemuaPegawaiController::class, 'export_excel'])->name('gaji_semua_pegawai.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);
        Route::get('/gaji_semua_pegawai/export_pdf', [GajiSemuaPegawaiController::class, 'export_pdf'])->name('gaji_semua_pegawai.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);

        // export pengajuan penarikan gaji
        Route::get('/pengajuan_penarikan_gaji/export_excel', [PengajuanPenarikanGajiController::class, 'export_excel'])->name('pengajuan_penarikan_gaji.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);
        Route::get('/pengajuan_penarikan_gaji/export_pdf', [PengajuanPenarikanGajiController::class, 'export_pdf'])->name('pengajuan_penarikan_gaji.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list pengajuan penarikan gaji']);

        // export riwayat penarikan gaji
        Route::get('/riwayat_penarikan_gaji/export_excel', [RiwayatPenarikanGajiController::class, 'export_excel'])->name('riwayat_penarikan_gaji.export_excel')->middleware(['auth', 'verified', 'role_or_permission:list riwayat semua ajuan']);
        Route::get('/riwayat_penarikan_gaji/export_pdf', [RiwayatPenarikanGajiController::class, 'export_pdf'])->name('riwayat_penarikan_gaji.export_pdf')->middleware(['auth', 'verified', 'role_or_permission:list riwayat semua ajuan']);

        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
        Route::resource('admin', AdminController::class);
        Route::resource('pegawai', PegawaiController::class);
        Route::resource('sales', SalesController::class);
        Route::resource('items', ItemController::class);
        Route::resource('produks', ProdukController::class);
        Route::resource('riwayat_stok_produk', RiwayatStokProdukController::class);
        Route::resource('invoice', PesananController::class);
        Route::resource('konfirmasi_pesanan', KonfirmasiPesananController::class);
        Route::resource('kegiatan', KegiatanController::class);
        Route::resource('riwayat_kegiatan_pegawai', RiwayatKegiatanPegawaiController::class);
        Route::resource('riwayat_kegiatan_admin', RiwayatKegiatanAdminController::class);
        Route::resource('gaji_per_produk', GajiPerProdukController::class);
        Route::resource('gaji_semua_pegawai', GajiSemuaPegawaiController::class);
        Route::resource('pengajuan_penarikan_gaji', PengajuanPenarikanGajiController::class);
        Route::resource('konfirmasi_penarikan_gaji', KonfirmasiPenarikanGajiController::class);
        Route::resource('riwayat_penarikan_gaji', RiwayatPenarikanGajiController::class);

        // diagram
        Route::get('/diagram_admin', [AdminController::class, 'diagram'])->name('admin.diagram')->middleware(['auth', 'verified', 'role_or_permission:list admin']);
        Route::get('/diagram_pegawai', [PegawaiController::class, 'diagram'])->name('pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list pegawai']);
        Route::get('/diagram_sales', [SalesController::class, 'diagram'])->name('sales.diagram')->middleware(['auth', 'verified', 'role_or_permission:list sales']);
        Route::get('/diagram_produk', [ProdukController::class, 'diagram'])->name('produks.diagram')->middleware(['auth', 'verified', 'role_or_permission:list produk']);
        Route::get('/diagram_stok_masuk', [RiwayatStokProdukController::class, 'diagram'])->name('riwayat_stok_produk.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat stok produk']);
        Route::get('/diagram_pesanan', [PesananController::class, 'diagram'])->name('invoice.diagram')->middleware(['auth', 'verified', 'role_or_permission:list pesanan']);
        Route::get('/diagram_gaji_pegawai', [GajiSemuaPegawaiController::class, 'diagram'])->name('gaji_semua_pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list gaji semua pegawai']);
        Route::get('/diagram_kegiatan_pegawai', [RiwayatKegiatanPegawaiController::class, 'diagram'])->name('riwayat_kegiatan_pegawai.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan pegawai']);
        Route::get('/diagram_kegiatan_admin', [RiwayatKegiatanAdminController::class, 'diagram'])->name('riwayat_kegiatan_admin.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat kegiatan admin']);
        Route::get('/diagram_riwayat_penarikan_gaji', [RiwayatPenarikanGajiController::class, 'diagram'])->name('riwayat_penarikan_gaji.diagram')->middleware(['auth', 'verified', 'role_or_permission:list riwayat semua ajuan']);
        

        // konfirmasi konfirmasi_penarikan_gaji
        Route::patch('/konfirmasi_penarikan_gaji/{konfirmasi_penarikan_gaji}/tolak', [KonfirmasiPenarikanGajiController::class, 'tolak_ajuan'])->name('konfirmasi_penarikan_gaji.tolak_ajuan');
        Route::patch('/konfirmasi_penarikan_gaji/{konfirmasi_penarikan_gaji}/terima', [KonfirmasiPenarikanGajiController::class, 'terima_ajuan'])->name('konfirmasi_penarikan_gaji.terima_ajuan');

        // selesaikan kegiatan
        Route::patch('/kegiatan/{kegiatan}/selesai', [KegiatanController::class, 'selesaikan_kegiatan'])->name('kegiatan.selesai');

        // mengajukan penarikan gaji
        Route::patch('/pengajuan_penarikan_gaji/{gaji_pegawai}/ajukan', [PengajuanPenarikanGajiController::class, 'ajukan'])->name('pengajuan_penarikan_gaji.ajukan');
    });
