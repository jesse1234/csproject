<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{

    public function welcome()
    {
        return view('welcome');
    }
    public function index()
    {
        $product=Product::paginate(3);
        $user= auth()->user();

        return view('home.userpage',compact('product'));
    }

    public function dashboard()
    {
        $product=Product::paginate(3);
        $user= auth()->user();
        $count=Cart::where('email',$user->email)->count();
        return view('home.userpage',compact('product','count'));
    }

    public function product_details($id)
    {
        $product = Product::find($id);


        return view('home.product_details',compact('product'));
    }
     
    public function add_to_cart(Request $request,$id)
    {
        if(Auth::id())
        {
            $user=Auth::user();
            $product=Product::find($id);
            $cart=new Cart;
            $cart->name=$user->name;
            $cart->email=$user->email;
            //$cart->phone=$user->phone;
            //$cart->address=$user->address;
            $cart->user_id=$user->id;

            $cart->title=$product->title;
           
            if($product->discount_price != null)
            {
                $cart->price=$product->discount_price * $request->quantity;
            }
            else
            {
                $cart->price=$product->price * $request->quantity;
            }
            
           
            $cart->image=$product->image;
            $cart->product_id=$product->id;
            
            $cart->quantity=$request->quantity;
            $cart->save();

            return redirect()->back()->with('message','Item has been added to cart');
        }
        else
        {
            return redirect('login')->with('message','Please log in and register before placing an order');
        }
    }

    public function cart()
    {
        
        $user= auth()->user();
        $cart = Cart::where('email',$user->email)->get();
        $count=Cart::where('email',$user->email)->count();
        return view('home.cart',compact('count','cart'));
    }

    public function remove_cart($id)
    {
        $cart=Cart::find($id);
        $cart->delete();
        return redirect()->back()->with('success','Product removed from cart successfully');
    }

    public function updateCart(Request $request)
    {
        $itemIds = $request->input('itemId');
        $quantities = $request->input('quantity');

        foreach ($itemIds as $index => $itemId) {
            // Find the cart item in the database
            $cartItem = Cart::find($itemId);

            if ($cartItem) {
                // Update the quantity
                $cartItem->quantity = $quantities[$index];
                $cartItem->total_price = $cartItem->price * $quantities[$index];
                $cartItem->save();
            }
        }

        // Redirect back to the cart page or any other appropriate page
        return redirect()->back()->with('success', 'Cart items updated successfully');
    }
}
