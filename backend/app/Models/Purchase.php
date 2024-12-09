<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'purchases';
    protected $fillable = ['transaction_id', 'tanggal_pembelian', 'total_pembelian', 'supplier_id'];

    public function category()
    {
        return $this->belongsTo(Supplier::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}
