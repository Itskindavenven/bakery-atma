<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class pegawai extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'pegawai';
    protected $primaryKey = 'id_pegawai';

    public $timestamps = false;
    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'id_role',
        'username',
        'password',
        'email',
        'verify_key',
        'active'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
