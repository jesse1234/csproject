<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\OrderItems;


class Order extends Model
{
    use HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function orderitems()
    {
       return $this->hasMany(OrderItems::class); 
    }
}
