<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

    protected $fillable = [
        'absensi_check_in_id',
        'absensi_check_out_id',
        'jam_kerja',

    ];
}
