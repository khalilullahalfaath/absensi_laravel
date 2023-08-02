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

    public function records()
    {
        return $this->hasMany(Record::class, 'absensi_check_out_id', 'id');
    }

    public function checkIn()
    {
        return $this->belongsTo(AbsensiCheckIn::class, 'tanggal_presensi', 'tanggal');
    }
}
