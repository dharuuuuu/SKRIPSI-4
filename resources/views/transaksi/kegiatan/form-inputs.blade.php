@php $editing = isset($kegiatan) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Nama Item"/>
        <x-inputs.select name="item_id" required>
            @php $selected = old('item_id', ($editing ? $kegiatan->item_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Pilih Kegiatan</option>
            @foreach($items as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.label-with-asterisk label="Jumlah"/>
        <x-inputs.basic 
            type="number" 
            name='jumlah_kegiatan' 
            :value="old('jumlah_kegiatan', ($editing ? $kegiatan->jumlah_kegiatan : ''))"
            :min="0" 
            placeholder="Jumlah"
        ></x-inputs.basic>
    </x-inputs.group>    

    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <x-inputs.group class="w-full">
        <x-inputs.label-with-asterisk label="Nama Pegawai"/>
        <x-inputs.select name="user_id" required readonly>
            <option value="{{ Auth::user()->id }}" selected>{{ Auth::user()->nama }}</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="catatan"
            label="Catatan"
            maxlength="255"
            >{{ old('catatan', ($editing ? $kegiatan->catatan : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <input type="hidden" name="status_kegiatan" value="Sedang Dikerjakan">
</div>

<script>
    document.getElementById("user_id").addEventListener("mousedown", function(event){
        event.preventDefault();
    });

    document.getElementById("user_id").addEventListener("keydown", function(event){
        event.preventDefault();
    });
</script>

