<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kegiatan List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}" placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>
                                    <div class="ml-1">
                                        <button type="submit" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="flex items-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('kegiatan.index', ['paginate' => $value, 'search' => $search]) }}" {{ $kegiatans->perPage() == $value ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </x-inputs.select>
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp;Data
                                    </span>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Kegiatan::class)
                                <a href="{{ route('kegiatan.create') }}" class="button" id="createButton" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                    <i class="mr-1 icon ion-md-add"></i>
                                    @lang('crud.common.create')
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr>
                                <th class="px-4 py-3 text-left">No</th>
                                <th class="px-4 py-3 text-left">Kegiatan</th>
                                <th class="px-4 py-3 text-left">Nama Pegawai</th>
                                <th class="px-4 py-3 text-left">Jumlah</th>
                                <th class="px-4 py-3 text-left">Catatan</th>
                                <th class="px-4 py-3 text-left">Kegiatan Dibuat</th>
                                <th class="px-4 py-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($kegiatans as $key => $kegiatan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ $kegiatans->firstItem() + $key }}
                                    </td>
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ optional($kegiatan->item)->nama_item ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ optional($kegiatan->user)->nama ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ $kegiatan->jumlah_kegiatan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ $kegiatan->catatan ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-left" style="max-width: 400px">
                                        {{ $kegiatan->kegiatan_dibuat ?? '-'}}
                                    </td>
                                    <td class="px-4 py-3 text-center" style="width: 134px;">
                                        <div role="group" aria-label="Row Actions" class="relative inline-flex align-middle">
                                            @can('view', $kegiatan)
                                                <a href="{{ route('kegiatan.show', $kegiatan) }}" class="mr-1">
                                                    <button type="button" class="button">
                                                        <i class="icon ion-md-eye"></i>
                                                    </button>
                                                </a>
                                            @endcan
                                            @can('update', $kegiatan)
                                                <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="mr-1">
                                                    <button type="button" class="button">
                                                        <i class="icon ion-md-create"></i>
                                                    </button>
                                                </a>
                                            @endcan 
                                            @can('delete', $kegiatan)
                                                <form id="deleteForm{{ $kegiatan->id }}" action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="button" onclick="confirmDelete('{{ $kegiatan->id }}')">
                                                        <i class="icon ion-md-trash text-red-600"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No Kegiatan Found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $kegiatans->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>

    <script>
        function confirmDelete(kegiatanId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus kegiatan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm' + kegiatanId).submit();
                }
            });
        }

        function confirmSelesai(kegiatanId) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menyelesaikan kegiatan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('updateStatusForm' + kegiatanId).submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            var kegiatanCount = @json(count($kegiatans));

            var createButton = document.getElementById('createButton');
            if (createButton) {
                createButton.addEventListener('click', function (event) {
                    if (kegiatanCount >= 3) {
                        event.preventDefault(); // Mencegah form submit atau aksi default tombol
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Maksimal kegiatan yang bisa diambil adalah 3!",
                        });
                    }
                });
            }
        });
    </script>
</x-app-layout>
