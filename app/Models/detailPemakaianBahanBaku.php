<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailPemakaianBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pemakaian',
        'id_bahan',
        'kuantitas',
    ];

    public $timestamps = false;

    public function pemakaianBahanBaku()
    {
        return $this->belongsTo(pemakaianBahanBaku::class, 'id_pemakaian');
    }

    public function bahanBaku()
    {
        return $this->belongsTo(bahan_baku::class, 'id_bahan');
    }
}