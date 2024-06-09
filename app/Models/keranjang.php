<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class keranjang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'id_produk',
        'id_hampers',
        'jumlah_produk',
        'subtotal',
    ];

    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo(produk::class, 'id_produk');
    }

    public function hampers()
    {
        return $this->belongsTo(hampers::class, 'id_hampers');
    }
}
