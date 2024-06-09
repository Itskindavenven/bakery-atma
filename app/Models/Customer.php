<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class customer extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

    protected $table = 'customer';
    protected $primaryKey = 'id_customer';
    protected $fillable = [
        'nama_lengkap',
        'tanggal_lahir',
        'email',
        'username',
        'email',
        'password',
        'notelp',
        'poin',
        'saldo',
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
}
