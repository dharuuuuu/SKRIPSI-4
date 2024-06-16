<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Penarikan Gaji List
        </h2>
    </x-slot>

    <div class="mb-1 mt-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            Nama Pegawai
                        </h5>
                        <span>{{ $gaji_pegawai->user->nama ?? '-' }}</span>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            Gaji Tersedia
                        </h5>
                        <span>{{ IDR($gaji_pegawai->total_gaji_yang_bisa_diajukan) ?? '-' }}</span>
                        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal" style="background-color: #800000; border:black 0; padding: ;"><i class="fa-solid fa-eye"></i></button>
                    </div>

                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            Terhitung Tanggal
                        </h5>
                        <span>{{ $gaji_pegawai->terhitung_tanggal ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <form id="ajukan_penarikan_gaji_form" action="{{ route('pengajuan_penarikan_gaji.ajukan', Auth::user()->id) }}" method="POST" onsubmit="return AjukanPenarikanGaji(event)">
                        @csrf
                        @method('PATCH')
                        <div role="group" aria-label="Row Actions" class="text-right">
                            <button type="submit" id="createButton" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-add"></i>
                                Ajukan Penarikan Gaji
                            </button>
                        </div>
                    </form>
                </div>              
            </x-partials.card>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card> 
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex customers-center w-full">
                                    <x-inputs.text name="search" value="{{ $search ?? '' }}" placeholder="{{ __('crud.common.search') }}" autocomplete="off"></x-inputs.text>

                                    <div class="ml-1">
                                        <button type="submit" class="button" style="background-color: #800000; color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='#700000'; this.style.color='white';" onmouseout="this.style.backgroundColor='#800000'; this.style.color='white';">
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex customers-center w-full mt-2 mb-2">
                                    <span style="color: rgb(88, 88, 88);">
                                        &nbsp; Menampilkan &nbsp;
                                    </span>
                                    <x-inputs.select name="paginate" id="paginate" class="form-select" style="width: 75px" onchange="window.location.href = this.value">
                                        @foreach([10, 25, 50, 100] as $value)
                                            <option value="{{ route('pengajuan_penarikan_gaji.index', ['paginate' => $value, 'search' => $search]) }}" {{ $pengajuan_penarikan_gajis->perPage() == $value ? 'selected' : '' }}>
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
                            <a href="{{ route('pengajuan_penarikan_gaji.export_pdf') }}" class="button" style="background-color: rgb(129, 129, 129); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(120, 120, 120)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(129, 129, 129)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Pdf
                            </a>

                            <a href="{{ route('pengajuan_penarikan_gaji.export_excel') }}" class="button" style="background-color: rgb(83, 138, 0); color: white; transition: background-color 0.3s, color 0.3s;" onmouseover="this.style.backgroundColor='rgb(72, 121, 0)'; this.style.color='white';" onmouseout="this.style.backgroundColor='rgb(83, 138, 0)'; this.style.color='white';">
                                <i class="mr-1 icon ion-md-download"></i>
                                Excel
                            </a>
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead style="color: #800000">
                            <tr >
                                <th class="px-4 py-3 text-left">
                                    No
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Nama Pegawai
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Gaji Ditarik
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Terhitung Tanggal
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Sampai Tanggal
                                </th>
                                <th class="px-4 py-3 text-left">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($pengajuan_penarikan_gajis as $key => $pengajuan_penarikan_gaji)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengajuan_penarikan_gajis->firstItem() + $key }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengajuan_penarikan_gaji->user->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ IDR($pengajuan_penarikan_gaji->gaji_yang_diajukan) ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    @if ($pengajuan_penarikan_gaji->status == 'Diajukan')
                                        <div
                                            style="min-width: 80px;"
                                            class="
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-yellow-600
                                                text-white
                                            "
                                        >
                                            {{ $pengajuan_penarikan_gaji->status ?? '-' }}
                                        </div>
                                    @elseif ($pengajuan_penarikan_gaji->status == 'Diterima')
                                        <div
                                            style="min-width: 80px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-green-600
                                                text-white
                                            "
                                        >
                                            {{ $pengajuan_penarikan_gaji->status ?? '-' }}
                                        </div>
                                    @elseif ($pengajuan_penarikan_gaji->status == 'Ditolak')
                                        <div
                                            style="min-width: 80px;"
                                            class=" 
                                                inline-block
                                                py-1
                                                text-center text-sm
                                                rounded
                                                bg-rose-600
                                                text-white
                                            "
                                        >
                                            {{ $pengajuan_penarikan_gaji->status ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengajuan_penarikan_gaji->mulai_tanggal ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left" style="max-width: 400px">
                                    {{ $pengajuan_penarikan_gaji->akhir_tanggal ?? '-' }}
                                </td>
                                </td>
                                <td class="px-4 py-3 text-center" style="width: 134px;">
                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                        @can('view', $pengajuan_penarikan_gaji)
                                            <a href="{{ route('pengajuan_penarikan_gaji.show', $pengajuan_penarikan_gaji) }}" class="mr-1">
                                                <button type="button" class="button">
                                                    <i class="icon ion-md-eye"></i>
                                                </button>
                                            </a>
                                        @endcan
                                        @if ($pengajuan_penarikan_gaji->status == 'Diajukan')
                                            @can('delete', $pengajuan_penarikan_gaji)
                                                <form id="deleteForm" action="{{ route('pengajuan_penarikan_gaji.destroy', $pengajuan_penarikan_gaji->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div role="group" aria-label="Row Actions" class=" relative inline-flex align-middle">
                                                        <button type="button" class="button" onclick="confirmDelete('{{ $pengajuan_penarikan_gaji->id }}')">
                                                            <i class=" icon ion-md-trash text-red-600"></i>
                                                        </button>
                                                    </div>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" style="display: table-cell; text-align: center; vertical-align: middle;">
                                    No Penarikan Gaji Found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="7">
                                    <div class="mt-10 px-4">
                                        {!! $pengajuan_penarikan_gajis->render() !!}
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
        function AjukanPenarikanGaji(event) {
            event.preventDefault(); // Mencegah form dikirim secara langsung
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin mengajukan penarikan gaji?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('ajukan_penarikan_gaji_form').submit(); // Mengirim form jika konfirmasi diterima
                }
            });
        }

        function confirmDelete(ajuanId) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Konfirmasi hapus ajuan',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika konfirmasi, submit formulir secara manual
                    document.getElementById('deleteForm').action = '{{ route('pengajuan_penarikan_gaji.destroy', '') }}/' + ajuanId;
                    document.getElementById('deleteForm').submit();
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            var kegiatanCount = @json(count($count_ajuan));

            var createButton = document.getElementById('createButton');
            if (createButton) {
                createButton.addEventListener('click', function (event) {
                    if (kegiatanCount >= 1) {
                        event.preventDefault();
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Maksimal pengajuan gaji adalah 1 kali!",
                        });
                    }
                });
            }
        });
        </script>
</x-app-layout>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Gaji</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Isi modal di sini -->
                <table class="table">
                    <thead>
                        <tr>
                            <th style="min-width: 100px; max-width: 100px;">Nomor</th>
                            <th style="min-width: 250px;">Nama Kegiatan</th>
                            <th style="min-width: 250px;">Jumlah Kegiatan Selesai</th>
                            <th style="min-width: 150px;">Gaji Per Item</th>
                            <th style="min-width: 150px;">Total Gaji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detail_gaji_pegawais as $key => $detail_gaji_pegawai)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $detail_gaji_pegawai->nama_item }}</td>
                                <td>{{ $detail_gaji_pegawai->total_jumlah_kegiatan }}</td>
                                <td>{{ IDR($detail_gaji_pegawai->gaji_per_item) }}</td>
                                <td>{{ IDR($detail_gaji_pegawai->total_jumlah_kegiatan * $detail_gaji_pegawai->gaji_per_item) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3"></th>
                            <th style="text-align:left;">TOTAL GAJI</th>
                            <th>{{ IDR($gaji_pegawai->total_gaji_yang_bisa_diajukan) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>