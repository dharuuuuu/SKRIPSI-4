@php $editing = isset($user) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama"/>
        <x-inputs.text
            name="nama"
            :value="old('nama', ($editing ? $user->nama : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jenis Kelamin"/>
        <x-inputs.select name="jenis_kelamin">
            <option disabled selected>Pilih Jenis Kelamin</option>
            @php $selected = old('jenis_kelamin', ($editing ? $user->jenis_kelamin : '')) @endphp
            <option value="Laki-Laki" {{ $selected == 'Laki-Laki' ? 'selected' : '' }} >Laki-Laki</option>
            <option value="Perempuan" {{ $selected == 'Perempuan' ? 'selected' : '' }} >Perempuan</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Email"/>
        <x-inputs.email
            name="email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Password"/>
        <x-inputs.password
            name="password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Alamat"/>
        <x-inputs.text
            name="alamat"
            :value="old('alamat', ($editing ? $user->alamat : ''))"
            maxlength="255"
            placeholder="Alamat"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="No Telepon"/>
        <x-inputs.text
            name="no_telepon"
            :value="old('no_telepon', ($editing ? $user->no_telepon : ''))"
            maxlength="255"
            placeholder="No Telepon"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Tanggal Lahir"/>
        <x-inputs.date
            name="tanggal_lahir"
            value="{{ old('tanggal_lahir', ($editing ? optional($user->tanggal_lahir)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.roles.name')
        </h4>

        <div class="py-2">
            @foreach ($roles as $role)
            <div>
                <x-inputs.checkbox
                    id="role{{ $role->id }}"
                    name="roles[]"
                    label="{{ ucfirst($role->name) }}"
                    value="{{ $role->id }}"
                    :checked="isset($user) ? $user->hasRole($role) : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>
</div>
