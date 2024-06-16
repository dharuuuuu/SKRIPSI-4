<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
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
            'nama' => ['required', Rule::unique('customers', 'nama')->ignore($this->customer)],
            'email' => ['required', Rule::unique('customers', 'email')->ignore($this->customer), 'email'],
            'no_telepon' => ['required'],
            'alamat' => ['required'],
            'tagihan' => ['nullable'],
        ];
    }
}
