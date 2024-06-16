@php $editing = isset($riwayat_stok_produk) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Produk"/>
        <x-inputs.select name="id_produk" required>
            @php $selected = old('id_produk', ($editing ? $riwayat_stok_produk->id_produk : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih produk</option>
            @foreach($produks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Stok Masuk"/>
        <x-inputs.basic 
            type="number" 
            name='stok_masuk' 
            :value="old('stok_masuk', ($editing ? $user->stok_masuk : ''))" 
            :min="0"
            placeholder="Stok Masuk"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="catatan"
            label="Catatan"
            maxlength="255"
            >{{ old('catatan', ($editing ? $produk->catatan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
