<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kegiatan extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['item_id', 'user_id', 'catatan', 'status_kegiatan', 'jumlah_kegiatan', 'tangal_selesai'];

    protected $searchableFields = ['item_id', 'user_id'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
