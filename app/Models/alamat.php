<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alamat extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_customer',
        'alamat',
    ];

    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'nomor_transaksi');
    }

}