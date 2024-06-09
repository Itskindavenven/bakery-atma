<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resep_bahan extends Model
{
    use HasFactory;

    protected $table= 'resep_bahan';
    protected $fillable = [
        'id_resep',
        'id_bahan',
        'jumlah',
        'satuan'
    ];
}
