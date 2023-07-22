<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Product;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout_page($totalprice)
    {
        $user= auth()->user();
        $count=Cart::where('user_id',Auth::id())->count();
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
    $count=Cart::where('user_id',Auth::id())->count();
    return view('home.payment_method', compact('totalprice','count'));
}

public function mpesa_form($totalprice){
    $user= auth()->user();
    $totalprice=Order::where('total_price',$user->total_price)->get();
    $count=Cart::where('user_id',Auth::id())->count();
    return view('home.mpesa', compact('totalprice','count'));
}

public function checkoutindex($totalprice)
{
    $count=Cart::where('user_id',Auth::id())->count();
    $totalprice = $totalprice;
    $old_cartItems = Cart::where('user_id',Auth::id())->get();
    foreach($old_cartItems as $item)
    {
        if(Product::where('id',$item->product_id)->where('stock',$item->stock)->exists())
        {
            $removeItem = Cart::where('user_id',Auth::id())->where('product_id',$item->product_id)->first();
            $removeItem->delete();
        }
    }
    $cartItems = Cart::where('user_id',Auth::id())->get();
    return view('home.checkout',compact('cartItems','totalprice','count'));
}

public function place_order(Request $request, $totalprice)
{
    $carts = Cart::where('user_id',Auth::id())->get();

    foreach($carts as $carts)
    {
        $order = new Order;
        $order->name = $request->input('name');
        $order->phone = $request->input('phone');
        $order->email = $request->input('email');
        $order->address = $request->input('address');
        $order->region = $request->input('region');
        $order->state = $request->input('state');
        $order->zip_code = $request->input('zip_code');
        $order->product_id = $carts->product_id;
     
        $order->user_id = Auth::id();
        $order->total_price = $totalprice;
        $order->save();
       
    }
   

    $order->id;
    $cartItems = Cart::where('user_id',Auth::id())->get();
    foreach($cartItems as $item)
    {
        OrderItems::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->products->discount_price ?? $item->products->price,
        ]);

        $prod = Product::where('id',$item->product_id)->first();
        $prod->stock = $prod->stock - $item->quantity;
        $prod->update();
    }

    if(Auth::user()->address == null)
    {
        $user = User::where('id',Auth::id())->first();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        $user->region = $request->input('region');
        $user->state = $request->input('state');
        $user->zip_code = $request->input('zip_code');
        $user->update();
    }

    $cartItems = Cart::where('user_id',Auth::id())->get();
    Cart::destroy($cartItems);
    return redirect()->back()->with('success','Order placed successfully');

}

}

