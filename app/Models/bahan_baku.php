<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bahan_baku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';
    protected $primaryKey= 'id_bahan';
    protected $fillable= [
        'nama',
        'stock',
        'satuan',
        'harga'
    ];
}
