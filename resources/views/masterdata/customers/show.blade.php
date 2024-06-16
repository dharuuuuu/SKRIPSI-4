<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Show Customer
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('customers.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4 row">
                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Nama
                            </h5>
                            <span>{{ $customer->nama ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Email
                            </h5>
                            <span>{{ $customer->email ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                No Telepon
                            </h5>
                            <span>{{ $customer->no_telepon ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Alamat
                            </h5>
                            <span>{{ $customer->alamat ?? '-' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Tagihan
                            </h5>
                            <span>{{ IDR($customer->tagihan) ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Created At
                            </h5>
                            <span>{{ $customer->created_at ?? '-' }}</span>
                        </div>

                        <div class="mb-4">
                            <h5 class="font-medium text-gray-700">
                                Updated At
                            </h5>
                            <span>{{ $customer->updated_at ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('customers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Customer::class)
                    <a href="{{ route('customers.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
