<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Kegiatan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('kegiatan.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4 row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Kegiatan
                            </h5>
                            <span>{{ optional($kegiatan->item)->nama_item ?? '-'}}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Pegawai
                            </h5>
                            <span>{{ optional($kegiatan->user)->nama ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Jumlah Kegiatan
                            </h5>
                            <span>{{ $kegiatan->jumlah_kegiatan ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Status Kegiatan
                            </h5>
                            @if ($kegiatan->status_kegiatan == 'Selesai')
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
                                    <span>{{ $kegiatan->status_kegiatan ?? '-' }}</span>
                                </div>
                            @elseif ($kegiatan->status_kegiatan == 'Sedang Dikerjakan')
                                <div
                                    style="min-width: 135px;"
                                    class="
                                        inline-block
                                        py-1
                                        text-center text-sm
                                        rounded
                                        bg-yellow-600
                                        text-white
                                    "
                                >
                                    <span>{{ $kegiatan->status_kegiatan ?? '-' }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Catatan
                            </h5>
                            <span>{{ $kegiatan->catatan ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Tanggal Selesai
                            </h5>
                            <span>{{ $kegiatan->tanggal_selesai ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('kegiatan.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Kegiatan::class)
                    <a href="{{ route('kegiatan.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>