<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AturanPinjaman extends Model
{
    protected $table = 'aturan_pinjaman';

    protected $fillable = [
        'penghasilan_min',
        'penghasilan_max',
        'maksimal_pinjaman',
    ];
}