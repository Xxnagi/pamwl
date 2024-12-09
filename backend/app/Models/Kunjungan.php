<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kunjungan extends Model
{
    public $timestamps = false;
    protected $table = 'reservations';
    protected $fillable = [
        'perawatan', 'tanggal', 'dokter', 'pasien_id'
    ];
    use HasFactory;
}
