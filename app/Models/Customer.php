<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['nama', 'email', 'no_telepon', 'alamat', 'tagihan'];

    protected $searchableFields = ['*'];

    public function customer()
    {
        return $this->hasMany(Customer::class, 'customer_id');
    }
}
