<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nasabah extends Model
{
    use SoftDeletes;

    protected $table = 'nasabah';

    protected $fillable = [
        'kode_nasabah',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'pekerjaan',
        'pendapatan',
        'foto',
        'foto_ktp',
        'tanggal_daftar',
        'status',
        'created_by',
    ];

    /**
     * Relasi ke user/petugas input
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

     /**
     * Relasi ke pinjaman
     */
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }
}
