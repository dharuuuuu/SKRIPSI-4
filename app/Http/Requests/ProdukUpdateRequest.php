<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProdukUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'nama_produk' => ['required', Rule::unique('produks', 'nama_produk')->ignore($this->produk),  'max:255', 'string'],
            'stok_produk' => ['required'],
            'harga_produk_1' => ['required'],
            'harga_produk_2' => ['required'],
            'harga_produk_3' => ['required'],
            'harga_produk_4' => ['required'],
            'deskripsi_produk' => ['nullable'],
        ];
    }
}
