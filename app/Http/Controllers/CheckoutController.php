<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout_page($totalprice)
    {
        $user= auth()->user();
        $count=Cart::where('email',$user->email)->count();
        return view('home.checkout',compact('totalprice','count'));
    }

    public function checkout(Request $request, $totalprice)
{
    $user = Auth::user();
    $userid = $user->id;

    $data = Cart::where('user_id', '=', $userid)->get();

    foreach ($data as $cartItem) {
        $order = new Order;
        $order->name = $cartItem->name;
        $order->email = $cartItem->email;
        $order->phone_number = $request->phone_number;
        $order->address = $request->address;
        $order->region = $request->region;
        $order->user_id = $cartItem->user_id;
        $order->product_title = $cartItem->title;
        $order->image = $cartItem->image;
        $order->price = $cartItem->price;
        $order->total_price = $totalprice;
        $order->product_id = $cartItem->product_id;
        $order->payment_status = "Pending";
        $order->delivery_status = "Pending";
        $order->save();

        $cart_id = $cartItem->id;
        $cart = Cart::find($cart_id);
        $cart->delete();
    }

    return redirect()->route('payment_method')->with('success','Choose method of payment');
}

public function payment_method(){
    $user= auth()->user();
    $totalprice=Order::where('total_price',$user->total_price)->get();
    $count=Order::where('email',$user->email)->count();
    return view('home.payment_method', compact('totalprice','count'));
}

public function mpesa_form($totalprice){
    $user= auth()->user();
    $totalprice=Order::where('total_price',$user->total_price)->get();
    $count=Order::where('email',$user->email)->count();
    return view('home.mpesa', compact('totalprice','count'));
}

}

