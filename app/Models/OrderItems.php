<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product; 

class OrderItems extends Model
{
    protected $table = 'order_details';
    protected $fillable =[
        'order_id',
        'product_id',
        'price',
        'quantity',
        
    ];

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
