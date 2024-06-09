<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promo_point extends Model
{
    use HasFactory;

    protected $table= 'promo_point';
    protected $primaryKey = 'id_promo';
    protected $fillable = [
        'nama_promo',
        'jumlah'
    ];
}
