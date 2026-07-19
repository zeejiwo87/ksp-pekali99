<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'kode_user',
        'name',
        'username',
        'email',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'foto',
        'password',
        'role',
        'status',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Nasabah yang diinput user
     */
    public function nasabah()
    {
        return $this->hasMany(Nasabah::class, 'created_by');
    }

    /**
     * Pinjaman yang dibuat user
     */
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'created_by');
    }

    /**
     * Angsuran yang diterima user
     */
    public function pembayaranAngsuran()
    {
        return $this->hasMany(Angsuran::class, 'dibayar_oleh');
    }
}