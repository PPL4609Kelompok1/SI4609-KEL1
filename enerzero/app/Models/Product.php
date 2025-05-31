<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category'
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }    
}
