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
        return $this->belongsTo('App\Models\AbsensiCheckIn', 'absensi_check_in_id');
    }

    public function absensiCheckOut()
    {
        return $this->belongsTo('App\Models\AbsensiCheckOut', 'absensi_check_out_id');
    }
}
