<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesananStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => 'required|exists:users,id',
            'produk_id.*' => 'nullable|exists:produks,id',
            'harga.*' => 'nullable',
            'jumlah_pesanan.*' => 'nullable|integer|min:1',
        ];
    }
}
