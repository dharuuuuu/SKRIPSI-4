<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.items.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('items.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4 row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.items.inputs.name')
                            </h5>
                            <span>{{ $item->nama_item ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Gaji Per Item
                            </h5>
                            <span>{{ IDR($item->gaji_per_item) ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                @lang('crud.items.inputs.deskripsi')
                            </h5>
                            <span>{{ $item->deskripsi_item ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Created At
                            </h5>
                            <span>{{ $item->created_at ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Updated At
                            </h5>
                            <span>{{ $item->updated_at ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('items.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Item::class)
                    <a href="{{ route('items.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
