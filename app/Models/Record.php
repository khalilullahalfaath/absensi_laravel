<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'absensi_check_in_id',
        'absensi_check_out_id',
        'jam_kerja',

    ];

    public function absensiCheckIn()
    {
        return $this->belongsTo(AbsensiCheckIn::class, 'absensi_check_in_id');
    }

    public function absensiCheckOut()
    {
        return $this->belongsTo(AbsensiCheckOut::class, 'absensi_check_out_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
