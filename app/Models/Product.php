<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Add 'category_id' to fillable to allow mass assignment
    protected $fillable = [
        'productName',
        'price',
        'quantity',
        'warranty',
        'description',
        'category_id', // Add this
    ];
}