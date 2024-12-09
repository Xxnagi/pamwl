<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    protected $fillable = ['category_name', 'category_description'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
