@php $editing = isset($item) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Item"/>
        <x-inputs.text
            name="nama_item"
            :value="old('nama_item', ($editing ? $item->nama_item : ''))"
            maxlength="255"
            placeholder="Nama Item"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Gaji Per Item"/>
        <x-inputs.basic 
            type="number" 
            name='gaji_per_item' 
            :value="old('gaji_per_item', ($editing ? $item->gaji_per_item : ''))" 
            :min="0" 
            placeholder="Harga Item"
        ></x-inputs.basic>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="deskripsi_item"
            label="Deskripsi Item"
            maxlength="255"
            >{{ old('deskripsi_item', ($editing ? $item->deskripsi_item : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
</div>
