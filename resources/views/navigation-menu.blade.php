<nav x-data="{ open: false }" class="bg-gray-100 border-b border-gray-200">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('menu') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="" style="width: 90px;">
                    </a>
                </div>

                 <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('menu') }}" :active="request()->routeIs('menu')">
                        {{ __('Kembali ke Menu') }}
                    </x-nav-link>
                </div>

                @can('view-any', App\Models\User::class)
                    @if (request()->routeIs('users.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('users.diagram') }}" :active="request()->routeIs('users.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('users.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                                Users
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('view-any', App\Models\Customer::class)
                    @if (request()->routeIs('customers.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('customers.diagram') }}" :active="request()->routeIs('customers.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('customers.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('customers.index') }}" :active="request()->routeIs('customers.index')">
                                Customers
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('view-any', App\Models\Produk::class)
                    @if (request()->routeIs('produks.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('produks.diagram') }}" :active="request()->routeIs('produks.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('produks.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('produks.index') }}" :active="request()->routeIs('produks.index')">
                                Produk
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('view-any', App\Models\RiwayatStokProduk::class)
                    @if (request()->routeIs('riwayat_stok_produk.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_stok_produk.diagram') }}" :active="request()->routeIs('riwayat_stok_produk.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('riwayat_stok_produk.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_stok_produk.index') }}" :active="request()->routeIs('riwayat_stok_produk.index')">
                                Stok Masuk
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('view-any', App\Models\Invoice::class)
                    @if (request()->routeIs('invoice.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('invoice.diagram') }}" :active="request()->routeIs('invoice.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('invoice.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('invoice.index') }}" :active="request()->routeIs('invoice.index')">
                                Pesanan
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('list_riwayat_kegiatan_pegawai', App\Models\Kegiatan::class)
                    @if (request()->routeIs('riwayat_kegiatan_pegawai.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_kegiatan_pegawai.diagram') }}" :active="request()->routeIs('riwayat_kegiatan_pegawai.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('riwayat_kegiatan_pegawai.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_kegiatan_pegawai.index') }}" :active="request()->routeIs('riwayat_kegiatan_pegawai.index')">
                                Riwayat Kegiatan
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('list_riwayat_kegiatan_admin', App\Models\Kegiatan::class)
                    @if (request()->routeIs('riwayat_kegiatan_admin.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_kegiatan_admin.diagram') }}" :active="request()->routeIs('riwayat_kegiatan_admin.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('riwayat_kegiatan_admin.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_kegiatan_admin.index') }}" :active="request()->routeIs('riwayat_kegiatan_admin.index')">
                                Riwayat Kegiatan
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('view-any', App\Models\GajiPegawai::class)
                    @if (request()->routeIs('gaji_semua_pegawai.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('gaji_semua_pegawai.diagram') }}" :active="request()->routeIs('gaji_semua_pegawai.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('gaji_semua_pegawai.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('gaji_semua_pegawai.index') }}" :active="request()->routeIs('gaji_semua_pegawai.index')">
                                Gaji Pegawai
                            </x-nav-link>
                        </div>
                    @endif
                @endcan


                @can('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class)
                    @if (request()->routeIs('riwayat_penarikan_gaji.index') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_penarikan_gaji.diagram') }}" :active="request()->routeIs('riwayat_penarikan_gaji.diagram')">
                                Diagram
                            </x-nav-link>
                        </div>
                    @endif

                    @if (request()->routeIs('riwayat_penarikan_gaji.diagram') ) 
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link href="{{ route('riwayat_penarikan_gaji.index') }}" :active="request()->routeIs('riwayat_penarikan_gaji.index')">
                                Riwayat Penarikan Gaji
                            </x-nav-link>
                        </div>
                    @endif
                @endcan
                

                {{--
                @php
                    $masterdataMenuVisible = Gate::check('view-any', App\Models\User::class) || Gate::check('view-any', App\Models\Item::class) || Gate::check('view-any', App\Models\Produk::class) || Gate::check('view-any', App\Models\Customer::class);

                    $transaksiMenuVisible = Gate::check('view-any', App\Models\Invoice::class) || Gate::check('view-any', App\Models\RiwayatStokProduk::class) || Gate::check('view-any', App\Models\Kegiatan::class);

                    $GajiMenuVisible = Gate::check('view-any', App\Models\GajiPegawai::class) || Gate::check('view-any', App\Models\PenarikanGaji::class) || Gate::check('list_ajuan', App\Models\PenarikanGaji::class) || Gate::check('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class); 

                    $rpMenuVisible = Gate::check('view-any', Spatie\Permission\Models\Role::class) || Gate::check('view-any', Spatie\Permission\Models\Permission::class);
                @endphp

                @if ($masterdataMenuVisible)
                    <x-nav-dropdown title="Masterdata" align="right" width="48">
                        @can('view-any', App\Models\User::class)
                            <x-dropdown-link href="{{ route('users.index') }}">
                            Users
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Customer::class)
                            <x-dropdown-link href="{{ route('customers.index') }}">
                            Customers
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Item::class)
                            <x-dropdown-link href="{{ route('items.index') }}">
                            Items
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Produk::class)
                            <x-dropdown-link href="{{ route('produks.index') }}">
                            Produk
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if ($transaksiMenuVisible)
                    <x-nav-dropdown title="Transaksi" align="right" width="48">
                        @can('view-any', App\Models\RiwayatStokProduk::class)
                            <x-dropdown-link href="{{ route('riwayat_stok_produk.index') }}">
                            Stok Produk
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Invoice::class)
                            <x-dropdown-link href="{{ route('invoice.index') }}">
                            Pesanan
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Kegiatan::class)
                            <x-dropdown-link href="{{ route('kegiatan.index') }}">
                            Kegiatan
                            </x-dropdown-link>
                        @endcan
                        @can('list_riwayat_kegiatan_pegawai', App\Models\Kegiatan::class)
                            <x-dropdown-link href="{{ route('riwayat_kegiatan_pegawai.index') }}">
                            Riwayat Kegiatan
                            </x-dropdown-link>
                        @endcan
                        @can('list_riwayat_kegiatan_admin', App\Models\Kegiatan::class)
                            <x-dropdown-link href="{{ route('riwayat_kegiatan_admin.index') }}">
                            Riwayat Kegiatan
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if ($GajiMenuVisible)
                    <x-nav-dropdown title="Gaji" align="right" width="48">
                        @can('view-any', App\Models\GajiPegawai::class)
                            <x-dropdown-link href="{{ route('gaji_semua_pegawai.index') }}">
                            Gaji Pegawai
                            </x-dropdown-link>
                        @endcan

                        @can('view-any', App\Models\PenarikanGaji::class)
                            <x-dropdown-link href="{{ route('pengajuan_penarikan_gaji.index') }}">
                            Penarikan Gaji
                            </x-dropdown-link>
                        @endcan

                        @can('list_ajuan', App\Models\PenarikanGaji::class)
                            <x-dropdown-link href="{{ route('konfirmasi_penarikan_gaji.index') }}">
                            Konfirmasi Penarikan Gaji
                            </x-dropdown-link>
                        @endcan

                        @can('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class)
                            <x-dropdown-link href="{{ route('riwayat_penarikan_gaji.index') }}">
                            Riwayat Penarikan Gaji
                            </x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif

                @if ($rpMenuVisible)
                    <x-nav-dropdown title="R&P" align="right" width="48">
                        @can('view-any', Spatie\Permission\Models\Role::class)
                            <x-dropdown-link href="{{ route('roles.index') }}">Roles</x-dropdown-link>
                        @endcan

                        @can('view-any', Spatie\Permission\Models\Permission::class)
                            <x-dropdown-link href="{{ route('permissions.index') }}">Permissions</x-dropdown-link>
                        @endcan
                    </x-nav-dropdown>
                @endif--}}
            </div> 

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="ml-3 relative">
                        <x-dropdown align="right" width="60">
                            <x-slot name="trigger">
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                        {{ Auth::user()->currentTeam->name }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content">
                                <div class="w-60">
                                    <!-- Team Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Manage Team') }}
                                    </div>

                                    <!-- Team Settings -->
                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                        {{ __('Team Settings') }}
                                    </x-dropdown-link>

                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                            {{ __('Create New Team') }}
                                        </x-dropdown-link>
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    <!-- Team Switcher -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        {{ __('Switch Teams') }}
                                    </div>

                                    @foreach (Auth::user()->allTeams() as $team)
                                        <x-switchable-team :team="$team" />
                                    @endforeach
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @endif

                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <span class="inline-flex rounded-md">
                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        {{ Auth::user()->nama }}

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                    {{ __('API Tokens') }}
                                </x-dropdown-link>
                            @endif

                            <div class="border-t border-gray-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('menu') }}" :active="request()->routeIs('menu')">
                {{ __('Menu') }}
            </x-responsive-nav-link>

            @can('view-any', App\Models\User::class)
                <x-responsive-nav-link href="{{ route('users.index') }}">
                    Users
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Customer::class)
                <x-responsive-nav-link href="{{ route('customers.index') }}">
                    Customers
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Item::class)
                <x-responsive-nav-link href="{{ route('items.index') }}">
                    Items
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Produk::class)
                <x-responsive-nav-link href="{{ route('produks.index') }}">
                    Produk
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\RiwayatStokProduk::class)
                <x-responsive-nav-link href="{{ route('riwayat_stok_produk.index') }}">
                    Stok Produk
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Invoice::class)
                <x-responsive-nav-link href="{{ route('invoice.index') }}">
                    Pesanan
                </x-responsive-nav-link>
            @endcan
            @can('view-any', App\Models\Kegiatan::class)
                <x-responsive-nav-link href="{{ route('kegiatan.index') }}">
                    Kegiatan
                </x-responsive-nav-link>
            @endcan
            @can('list_riwayat_kegiatan_pegawai', App\Models\Kegiatan::class)
                <x-responsive-nav-link href="{{ route('riwayat_kegiatan_pegawai.index') }}">
                    Riwayat Kegiatan
                </x-responsive-nav-link>
            @endcan
            @can('list_riwayat_kegiatan_admin', App\Models\Kegiatan::class)
                <x-responsive-nav-link href="{{ route('riwayat_kegiatan_admin.index') }}">
                    Riwayat Kegiatan
                </x-responsive-nav-link>
            @endcan

            @can('view-any', App\Models\GajiPegawai::class)
                <x-responsive-nav-link href="{{ route('gaji_semua_pegawai.index') }}">
                    Gaji Pegawai
                </x-responsive-nav-link>
            @endcan

            @can('view-any', App\Models\PenarikanGaji::class)
                <x-responsive-nav-link href="{{ route('pengajuan_penarikan_gaji.index') }}">
                    Penarikan Gaji
                </x-responsive-nav-link>
            @endcan

            @can('list_ajuan', App\Models\PenarikanGaji::class)
                <x-responsive-nav-link href="{{ route('konfirmasi_penarikan_gaji.index') }}">
                    Konfirmasi Penarikan Gaji
                </x-responsive-nav-link>
            @endcan

            @can('list_riwayat_semua_ajuan', App\Models\PenarikanGaji::class)
                <x-responsive-nav-link href="{{ route('riwayat_penarikan_gaji.index') }}">
                    Riwayat Penarikan Gaji
                </x-responsive-nav-link>
            @endcan

            @if (Auth::user()->can('view-any', Spatie\Permission\Models\Role::class) ||
                Auth::user()->can('view-any', Spatie\Permission\Models\Permission::class))

                @can('view-any', Spatie\Permission\Models\Role::class)
                <x-responsive-nav-link href="{{ route('roles.index') }}">Roles</x-responsive-nav-link>
                @endcan

                @can('view-any', Spatie\Permission\Models\Permission::class)
                <x-responsive-nav-link href="{{ route('permissions.index') }}">Permissions</x-responsive-nav-link>
                @endcan

            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <div class="border-t border-gray-200"></div>

                    <!-- Team Switcher -->
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Switch Teams') }}
                    </div>

                    @foreach (Auth::user()->allTeams() as $team)
                        <x-switchable-team :team="$team" component="responsive-nav-link" />
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</nav>
