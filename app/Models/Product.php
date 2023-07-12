<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'stock',
        'category_id',
        'image',
        'image_3d',
        'price',
        'discount_price',
        'vendor_id'
    ];
}
