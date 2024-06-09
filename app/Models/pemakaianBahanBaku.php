<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pemakaianBahanBaku extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pemakaian';

    protected $fillable = [
        'tanggal_pemakaian',
    ];

    public $timestamps = false;

    public function detailPemakaianBahanBaku()
    {
        return $this->hasMany(detailPemakaianBahanBaku::class, 'id_pemakaian');
    }
}