<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'nama_item' => ['required', 'unique:items,nama_item', 'max:255', 'string'],
            'gaji_per_item' => ['required'],
            'deskripsi_item' => ['nullable'],
        ];
    }
}
