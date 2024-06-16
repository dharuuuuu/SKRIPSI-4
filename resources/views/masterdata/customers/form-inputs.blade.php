@php $editing = isset($customer) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama"/>
        <x-inputs.text
            name="nama"
            :value="old('nama', ($editing ? $customer->nama : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Email"/>
        <x-inputs.text
            name="email"
            :value="old('email', ($editing ? $customer->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="No Telepon"/>
        <x-inputs.text
            name="no_telepon"
            :value="old('no_telepon', ($editing ? $customer->no_telepon : ''))"
            maxlength="255"
            placeholder="No Telepon"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Alamat"/>
        <x-inputs.text
            name="alamat"
            :value="old('alamat', ($editing ? $customer->alamat : ''))"
            maxlength="255"
            placeholder="Alamat"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.basic 
            type="number" 
            name='tagihan' 
            label='Tagihan' 
            :value="old('tagihan', ($editing ? $customer->tagihan : ''))" 
            :min="0"
            placeholder="Tagihan"
        ></x-inputs.basic>
    </x-inputs.group>
</div>
