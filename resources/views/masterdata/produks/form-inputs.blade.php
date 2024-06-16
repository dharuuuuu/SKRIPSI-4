@php $editing = isset($produk) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Produk"/>
        <x-inputs.text
            name="nama_produk"
            :value="old('nama_produk', ($editing ? $produk->nama_produk : ''))"
            maxlength="255"
            placeholder="Nama Produk"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Stok Produk"/>
        <x-inputs.basic 
            type="number" 
            name='stok_produk' 
            :value="old('stok_produk', ($editing ? $produk->stok_produk : ''))" 
            :min="0" 
            placeholder="Stok Produk"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 1"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_1' 
            :value="old('harga_produk_1', ($editing ? $produk->harga_produk_1 : ''))" 
            :min="0" 
            placeholder="Harga 1"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 2"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_2' 
            :value="old('harga_produk_2', ($editing ? $produk->harga_produk_2 : ''))" 
            :min="0" 
            placeholder="Harga 2"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 3"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_3'  
            :value="old('harga_produk_3', ($editing ? $produk->harga_produk_3 : ''))" 
            :min="0" 
            placeholder="Harga 3"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Harga 4"/>
        <x-inputs.basic 
            type="number" 
            name='harga_produk_4' 
            :value="old('harga_produk_4', ($editing ? $produk->harga_produk_4 : ''))" 
            :min="0" 
            placeholder="Harga 4"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $produk->image_produk ? \Storage::url($produk->image_produk) : '' }}')"
        >
            <x-inputs.partials.label
                name="image_produk"
                label="Gambar Produk"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image_produk"
                    id="image_produk"
                    @change="fileChosen"
                />
            </div>

            @error('image_produk') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="deskripsi_produk"
            label="Deskripsi Produk"
            maxlength="255"
            >{{ old('deskripsi_produk', ($editing ? $produk->deskripsi_produk : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
