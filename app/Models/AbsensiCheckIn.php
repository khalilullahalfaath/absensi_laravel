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
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function checkOut()
    {
        return $this->hasOne(AbsensiCheckOut::class, 'tanggal_presensi', 'tanggal');
    }

    public function records()
    {
        return $this->hasMany(Record::class, 'absensi_check_in_id', 'id');
    }
}
