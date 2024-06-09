<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'nomor_transaksi';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_customer',
        'tanggal_pemesanan',
        'tanggal_pengambilan',
        'pengambilan',
        'jarak',
        'total_harga',
        'poin',
        'status',
    ];

    public $timestamps = false;

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'nomor_transaksi');
    }

    public static function generateNomerTransaksi()
    {
        $count = self::count();
        $nomerTransaksi = $count + 1;
        $year = date('Y');
        $month = date('m');

        $nomerTransaksi = $year . '.' . $month . '.' . $nomerTransaksi;

        return $nomerTransaksi;
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'nomor_transaksi');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer');
    }
    public function resep()
    {
        return $this->belongsTo(resep::class, 'id_customer');
    }
}
