<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presensi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_presensi';

    protected $foreignKey = 'id_pegawai';

    protected $fillable = [
        'tanggal_presensi',
        'jam_masuk',
        'jam_keluar',
        'status_presensi'

    ];
    public function karyawan()
    {
        return $this->belongsTo(pegawai::class, 'id_pegawai');
    }
}
