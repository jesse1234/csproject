<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $total_product= Product::all()->count();
        $total_user= User::all()->count();
        $total_order= Order::all()->count();
        $order = Order::all();

        $total_revenue=0;

        foreach($order as $order)
        {
            $total_revenue=$total_revenue + $order->price;
        }

        $total_delivered=Order::where('delivery_status', '=', 'delivered')->get()->count();
        $total_pending=Order::where('delivery_status', '=', 'pending')->get()->count();
        return view('admin.dashboard',compact('total_pending','total_delivered','total_revenue','total_product','total_user','total_order'));
    }
}
