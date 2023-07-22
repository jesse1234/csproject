<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Cart extends Model
{
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'title',
        'price',
        'total_price',
        'price',
        'image',
        'product_id',
        'quantity'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
