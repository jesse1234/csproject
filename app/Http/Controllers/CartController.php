<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        $product_id = $request->input('product_id');
        $product_qty = $request->input('product_qty');
        

        if(Auth::check())
        {
            $prod_check = Product::where('id',$product_id)->first();

            if($prod_check)
            {
                if(Cart::where('product_id',$product_id)->where('user_id',Auth::id())->exists())
                {
                    return response()->json(['status' => $prod_check->title.' already added to cart']);

                }
                else
                {
                    $cartItem = new Cart();
                    $cartItem->product_id = $product_id;
                    $cartItem->user_id = Auth::id();
                    $cartItem->quantity = $product_qty;
                    $cartItem->save();
                    
                    return response()->json(['status' => $prod_check->title.' added to cart']);

    
                }
            }
        }
        else
        {
            return redirect('login')->with('message','Please login first');
        }
    }

    public function viewcart()
    {
        $count=Cart::where('user_id',Auth::id())->count();
        $cart = Cart::where('user_id','=',Auth::id())->get();
        return view('home.cart',compact('cart','count'));
    }

    public function updatecart(Request $request)
    {
        $prod_id = $request->input('product_id');
        $product_qty = $request->input('quantity');

        if(Auth::check())
        {
            if(Cart::where('product_id',$prod_id)->where('user_id',Auth::id())->exists())
            {
                $cart = Cart::where('product_id',$prod_id)->where('user_id',Auth::id())->first();
                $cart->quantity = $product_qty;
                $cart->update();
                return redirect()->back()->with('success', 'Quantity updated in cart');


            }
        }
    }

    public function cartcount()
    {
        $cart_count = Cart::where('user_id',Auth::id());
        return response()->json(['count' => $cart_count]); 
    }

}
