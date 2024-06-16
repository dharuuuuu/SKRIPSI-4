@php $editing = isset($pesanan) @endphp

<div class="flex flex-wrap">
    @if ($create == 'create')
        <x-inputs.group class="w-full" style="padding: 0 10px 40px 10px !important; font-size: 18px;">
            <x-inputs.label-with-asterisk label="Nama Customer"/>
            <x-inputs.select name="customer_id" required>
                <option disabled selected>Pilih Customer</option>
                @foreach($customers as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </x-inputs.select>
        </x-inputs.group>

        <div id="produk-container">
            <div class="produk-group" style="display: flex; flex-wrap: wrap;">
                <x-inputs.group style="width: 50px; padding: 5px 10px !important;">
                    <div>
                        <span class="produk-number">1</span>
                    </div>
                </x-inputs.group>

                <x-inputs.group style="width: 350px; padding: 0 10px !important;">
                    <x-inputs.select name="produk_id[]" required onchange="populateHarga(this)">
                        <option disabled selected>Pilih Produk</option>
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}" data-harga1="{{ $produk->harga_produk_1 }}" data-harga2="{{ $produk->harga_produk_2 }}" data-harga3="{{ $produk->harga_produk_3 }}" data-harga4="{{ $produk->harga_produk_4 }}">{{ $produk->nama_produk }}</option>
                        @endforeach
                    </x-inputs.select>
                </x-inputs.group>      
                
                <x-inputs.group style="width: 320px; padding: 0 10px !important;">
                    <x-inputs.select name="harga[]" required>
                        <option disabled selected>Pilih harga produk</option>
                    </x-inputs.select>
                </x-inputs.group>

                <x-inputs.group style="width: 350px; padding: 0 10px !important;">
                    <x-inputs.basic 
                        type="number" 
                        name='jumlah_pesanan[]' 
                        :min="0" 
                        placeholder="Jumlah Pesanan"
                    ></x-inputs.basic>
                </x-inputs.group>

                <x-inputs.group>
                    <button type="button" class="delete-produk" onclick="deleteProduk(this)" style="padding: 7px 15px; background-color:rgb(221, 221, 221); border-radius: 5px;">
                        <i class="icon ion-md-trash text-red-600"></i>
                    </button>
                </x-inputs.group>
            </div>
        </div>

        <div style="width: 100%; padding: 10px; margin-top: 20px;">
            <button
                type="button"
                class="tambah-produk-button"
                onclick="addProduk()"
            >
                + Tambah Produk
            </button>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        updateDeleteButtons();
        updateProductOptions();
    });

    function populateHarga(select) {
        var selectedOption = select.options[select.selectedIndex];
        var harga1 = selectedOption.getAttribute('data-harga1');
        var harga2 = selectedOption.getAttribute('data-harga2');
        var harga3 = selectedOption.getAttribute('data-harga3');
        var harga4 = selectedOption.getAttribute('data-harga4');
        
        var produkGroup = select.closest('.produk-group');
        var hargaSelect = produkGroup.querySelector('select[name^="harga["]') || produkGroup.querySelector('select[name="harga[]"]');
        hargaSelect.innerHTML = ''; 
        
        if (harga1) {
            hargaSelect.innerHTML += '<option value="' + harga1 + '">' + 'Harga 1 - Rp. ' + harga1 + '</option>';
        }
        if (harga2) {
            hargaSelect.innerHTML += '<option value="' + harga2 + '">' + 'Harga 2 - Rp. ' + harga2 + '</option>';
        }
        if (harga3) {
            hargaSelect.innerHTML += '<option value="' + harga3 + '">' + 'Harga 3 - Rp. ' + harga3 + '</option>';
        }
        if (harga4) {
            hargaSelect.innerHTML += '<option value="' + harga4 + '">' + 'Harga 4 - Rp. ' + harga4 + '</option>';
        }

        updateProductOptions();
    }

    function addProduk() {
        var container = document.getElementById('produk-container');
        var produkGroups = container.querySelectorAll('.produk-group');
        var produkGroup = produkGroups[0];
        var newProdukGroup = produkGroup.cloneNode(true);
        var inputs = newProdukGroup.querySelectorAll('input, select');
        
        inputs.forEach(function(input) {
            if (input.tagName.toLowerCase() === 'select') {
                input.selectedIndex = 0; // Mengatur kembali ke opsi pertama
            } else {
                input.value = '';
            }
        });

        // Update numbering
        newProdukGroup.querySelector('.produk-number').innerText = produkGroups.length + 1;

        container.appendChild(newProdukGroup);
        updateDeleteButtons();
        updateProductOptions();
    }

    function deleteProduk(button) {
        var container = document.getElementById('produk-container');
        var produkGroups = container.querySelectorAll('.produk-group');

        if (produkGroups.length > 1) {
            var produkGroup = button.closest('.produk-group');
            produkGroup.remove();

            // Update numbering
            produkGroups = container.querySelectorAll('.produk-group');
            produkGroups.forEach(function(group, index) {
                group.querySelector('.produk-number').innerText = index + 1;
            });
        }
        updateDeleteButtons();
        updateProductOptions();
    }

    function updateDeleteButtons() {
        var container = document.getElementById('produk-container');
        var produkGroups = container.querySelectorAll('.produk-group');
        produkGroups.forEach(function(group, index) {
            var deleteButton = group.querySelector('.delete-produk');
            if (produkGroups.length === 1) {
                deleteButton.disabled = true;
            } else {
                deleteButton.disabled = false;
            }
        });
    }

    function updateProductOptions() {
        var container = document.getElementById('produk-container');
        var produkGroups = container.querySelectorAll('.produk-group');
        var selectedProducts = [];

        produkGroups.forEach(function(group) {
            var select = group.querySelector('select[name="produk_id[]"]');
            if (select.value) {
                selectedProducts.push(select.value);
            }
        });

        produkGroups.forEach(function(group) {
            var select = group.querySelector('select[name="produk_id[]"]');
            var currentValue = select.value;
            var options = select.querySelectorAll('option');
            options.forEach(function(option) {
                if (selectedProducts.includes(option.value) && option.value !== currentValue) {
                    option.style.display = 'none';
                } else {
                    option.style.display = '';
                }
            });
        });
    }

</script>


