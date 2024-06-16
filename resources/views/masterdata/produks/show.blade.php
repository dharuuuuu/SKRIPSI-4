<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.produks.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('produks.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4 row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Nama
                            </h5>
                            <span>{{ $produk->nama_produk ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Stok
                            </h5>
                            <span>{{ $produk->stok_produk ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                harga 1
                            </h5>
                            <span>{{ IDR($produk->harga_produk_1) ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                harga 2
                            </h5>
                            <span>{{ IDR($produk->harga_produk_2) ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                harga 3
                            </h5>
                            <span>{{ IDR($produk->harga_produk_3) ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                harga 4
                            </h5>
                            <span>{{ IDR($produk->harga_produk_4) ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Image
                            </h5>
                            <x-partials.thumbnail
                                src="{{ $produk->image_produk ? \Storage::url($produk->image_produk) : '' }}"
                                size="150"
                            />
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Deskripsi
                            </h5>
                            <span>{{ $produk->deskripsi_produk ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Created At
                            </h5>
                            <span>{{ $produk->created_at ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Updated At
                            </h5>
                            <span>{{ $produk->updated_at ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('produks.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Produk::class)
                    <a href="{{ route('produks.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
