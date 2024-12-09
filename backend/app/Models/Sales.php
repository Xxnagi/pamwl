<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sales extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'sales';
    protected $fillable = [
        'transaction_id',
        'customer_id',
        'tanggal_penjualan',
        'total_penjualan'
    ];
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }
}
