<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_produk extends Model
{
    use HasFactory;
    protected $table = 'stock_produk';
    protected $fillable = [
        'id_produk',
        'stock',
        'tanggal_tersedia'
    ];
}
