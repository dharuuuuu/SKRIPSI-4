<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                @php
                    $masterdataMenuVisible = Gate::check('view-any', App\Models\User::class) || Gate::check('view-any', App\Models\Item::class) || Gate::check('view-any', App\Models\Produk::class) || Gate::check('view-any', App\Models\Customer::class);

                    $transaksiMenuVisible = Gate::check('view-any', App\Models\Invoice::class) || Gate::check('view-any', App\Models\RiwayatStokProduk::class) || Gate::check('view-any', App\Models\Kegiatan::class);

                    $GajiMenuVisible = Gate::check('view-any', App\Models\GajiPegawai::class) || Gate::check('view-any', App\Models\PenarikanGaji::class) || Gate::check('list_ajuan', App\Models\PenarikanGaji::class) || Gate::check('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class); 

                    $rpMenuVisible = Gate::check('view-any', Spatie\Permission\Models\Role::class) || Gate::check('view-any', Spatie\Permission\Models\Permission::class);
                @endphp

                @if ($masterdataMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">MASTERDATA</div>
                                        <div style="height: 3px; 
                                        background-color:#800000; 
                                        width: 70px; 
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\RiwayatStokProduk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('users.index') }}">
                                                <i class="fa-solid fa-users fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Users</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Customer::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('customers.index') }}">
                                                <i class="fa-sharp fa-solid fa-handshake fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Customers</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Item::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('items.index') }}">
                                                <i class="fa-solid fa-rectangle-list fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Items</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Produk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('produks.index') }}">
                                                <i class="fa-solid fa-box-open fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Produk</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($transaksiMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">TRANSAKSI</div>
                                        <div style="height: 2px; 
                                        background-color:#800000; 
                                        width: 70px; 
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\RiwayatStokProduk::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_stok_produk.index') }}">
                                                <i class="fa-solid fa-box-open fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Stok Masuk</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Invoice::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('invoice.index') }}">
                                                <i class="fa-solid fa-basket-shopping fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Pesanan</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('kegiatan.index') }}">
                                                <i class="fa-solid fa-clipboard-check fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Kegiatan</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_kegiatan_pegawai', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_kegiatan_pegawai.index') }}">
                                                <i class="fa-solid fa-clock-rotate-left fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Kegiatan</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_kegiatan_admin', App\Models\Kegiatan::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_kegiatan_admin.index') }}">
                                                <i class="fa-solid fa-clock-rotate-left fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Kegiatan</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($GajiMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">GAJI</div>
                                        <div style="height: 2px; 
                                        background-color:#800000; 
                                        width: 70px; 
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', App\Models\GajiPegawai::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('gaji_semua_pegawai.index') }}">
                                                <i class="fa-solid fa-sack-dollar fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Gaji Pegawai</div>
                                        </td>
                                    @endcan
                                    @can('view-any', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('pengajuan_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-hand-holding-dollar fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Penarikan Gaji</div>
                                        </td>
                                    @endcan
                                    @can('list_ajuan', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('konfirmasi_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-sack-xmark fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Konfirmasi Gaji</div>
                                        </td>
                                    @endcan
                                    @can('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('riwayat_penarikan_gaji.index') }}">
                                                <i class="fa-solid fa-money-bill-transfer fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Riwayat Gaji</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

                @if ($rpMenuVisible)
                    <div class="w-full flex justify-center">
                        <table class="table-auto" style="margin-bottom: 20px;">
                            <thead>
                                <tr>
                                    <th colspan="10" style="text-align: center;">
                                        <div class="judul_menu">R&P</div>
                                        <div style="height: 3px; 
                                        background-color:#800000; 
                                        width: 70px; 
                                        margin: 0 auto 15px auto;"></div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @can('view-any', Spatie\Permission\Models\Role::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('roles.index') }}">
                                                <i class="fa-solid fa-users-gear fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Roles</div>
                                        </td>
                                    @endcan
                                    @can('view-any', Spatie\Permission\Models\Permission::class)
                                        <td>
                                            <x-dropdown-link href="{{ route('permissions.index') }}">
                                                <i class="fa-solid fa-road-barrier fa-2x ikon"></i>
                                            </x-dropdown-link>
                                            <div style="text-align: center; font-size: 13px;">Permissions</div>
                                        </td>
                                    @endcan
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
