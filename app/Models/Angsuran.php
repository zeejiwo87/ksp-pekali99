<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Angsuran extends Model
{
    protected $table = 'angsuran';

    protected $fillable = [
        'pinjaman_id',
        'angsuran_ke',
        'tanggal_jatuh_tempo',
        'jumlah_tagihan',
        'tanggal_bayar',
        'jumlah_bayar',
        'dibayar_oleh',
        'foto_bukti',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_bayar' => 'date',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'dibayar_oleh');
    }
}
