<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'total_harga',
        'uang_diterima',
        'tip',
        'tanggal_pembayaran',
        'bukti_pembayaran',
    ];

    public $timestamps = false;

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'nomor_transaksi');
    }
}