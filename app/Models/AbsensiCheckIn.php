<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiCheckIn extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_presensi',
        'jam_masuk',
    ];
}
