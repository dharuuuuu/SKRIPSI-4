<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KegiatanStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'user_id' => 'required|exists:users,id',
            'status_kegiatan' => 'required',
            'jumlah_kegiatan' => 'integer|min:1',
            'tanggal_selesai' => 'nullable',
            'catatan' => 'nullable',
            'kegiatan_dibuat' => 'required',
        ];
    }
}
