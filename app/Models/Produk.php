<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama_produk', 'stok_produk', 'harga_produk_1', 'harga_produk_2', 'harga_produk_3', 'harga_produk_4', 'deskripsi_produk'];

    protected $searchableFields = ['nama_produk'];

    public function riwayat_stok_produk()
    {
        return $this->hasMany(RiwayatStokProduk::class, 'id_produk');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'produk_id');
    }
}
