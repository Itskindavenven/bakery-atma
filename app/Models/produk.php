<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    use HasFactory;
    protected $table= 'produk';
    protected $primaryKey ='id_produk';
    protected $fillable=[
        'nama',
        'jenis',
        'foto_produk',
        'harga',
        'id_penitip',
        'deskripsi'
    ];

    public function penitip()
    {
        return $this->belongsTo(penitip::class, 'id_penitip');
    }
}
