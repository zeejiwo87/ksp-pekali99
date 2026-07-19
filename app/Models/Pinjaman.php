<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pinjaman extends Model
{
    use SoftDeletes;

    protected $table = 'pinjaman';

    protected $fillable = [
        'nasabah_id',
        'created_by',
        'kode_pinjaman',
        'jumlah_pinjaman',
        'tenor',
        'tenor_satuan',
        'bunga_persen',
        'total_pinjaman',
        'angsuran_per_periode',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'status',
    ];

    /**
     * 🔗 Relasi ke Nasabah
     */
    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    /**
     * 🔗 Relasi ke User (petugas input)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function angsuran()
    {
        return $this->hasMany(Angsuran::class);
    }

    /**
     * 📊 Hitung total periode dalam minggu (helper)
     */
    public function getTotalPeriodeAttribute()
    {
        return match ($this->tenor_satuan) {
            'minggu' => $this->tenor,
            'bulan'  => $this->tenor * 4,
            'tahun'  => $this->tenor * 52,
        };
    }

    /**
     * 📊 Hitung bunga (helper)
     */
    public function getTotalBungaAttribute()
    {
        return ($this->bunga_persen / 100) * $this->jumlah_pinjaman;
    }

    /**
     * 📊 Hitung total pinjaman
     */
    public function getTotalPinjamanHitungAttribute()
    {
        return $this->jumlah_pinjaman + $this->total_bunga;
    }

    /**
     * 📊 Hitung angsuran manual (jika diperlukan)
     */
    public function getAngsuranHitungAttribute()
    {
        return $this->total_pinjaman / $this->total_periode;
    }
}
