<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';
    protected $fillable = ['supplier_name', 'supplier_contact'];

    public function products()
    {
        return $this->hasMany(Product::class, 'supplier_id');
    }
}