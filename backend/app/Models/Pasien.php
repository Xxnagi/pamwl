<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    public $timestamps = false;
    protected $table = 'patients';
    protected $fillable = [
        'nama', 'tanggal_lahir', 'nik', 'alamat', 'gender'
    ];
    use HasFactory;

    public function reservations(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
