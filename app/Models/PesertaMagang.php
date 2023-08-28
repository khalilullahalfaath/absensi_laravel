<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaMagang extends Model
{
    use HasFactory;
    protected $table = 'peserta_magang';

    protected $fillable = [
        'nama_peserta',
        'no_presensi',
        'status_peserta_aktif',
        'status_akun_aplikasi',
    ];
}
