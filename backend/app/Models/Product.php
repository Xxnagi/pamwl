<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model

{
    public $timestamps = false;
    protected $table = 'products';
    protected $primaryKey = 'product_id';
    protected $fillable = ['product_name', 'price', 'description', 'stock', 'supplier_id', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
