<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsensiCheckOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_presensi',
        'jam_keluar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
