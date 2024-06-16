<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Item extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama_item', 'gaji_per_item', 'deskripsi_item'];

    protected $searchableFields = ['nama_item', 'gaji_per_item'];

    public function kegiatan()
    {
        return $this->hasOne(Kegiatan::class, 'item_id');
    }
}
