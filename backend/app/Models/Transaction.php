<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $primaryKey = 'transaction_id';

    protected $table = 'transactions';
    protected $fillable = ['quantity', 'total', 'transaction_date', 'jenis_transaksi', 'admin_id', 'product_id'];

    public function sales(): HasOne
    {
        return $this->hasOne(Sales::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function purchase(): HasOne
    {
        return $this->hasOne(purchase::class);
    }
}
