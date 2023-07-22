<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Order;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{

    public function welcome()
    {
        $product=Product::paginate(3);
        $user= auth()->user();
        return view('home.userpage',compact('product'));
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
        $count=Cart::where('user_id',Auth::id())->count();
        return view('home.userpage',compact('product','count'));
    }

    public function product_details($id)
    {
        $product = Product::find($id);
        $user= auth()->user();
        $count=Cart::where('user_id',Auth::id())->count();

        return view('home.product_details',compact('product','count'));
    }
     
    public function add_to_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $product = Product::find($id);
    
            // Check if the requested quantity exceeds the available stock
            if ($request->quantity > $product->quantity) {
                return redirect()->back()->with('exceeded_stock', 'Selected quantity exceeds available stock');
            }
    
            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $userid)->get('id')->first();
    
            if ($product_exist_id) {
                $cart = Cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                $cart->save();
                return redirect()->back();
            } else {
                $cart = new Cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->user_id = $user->id;
    
                $cart->title = $product->title;
    
                if ($product->discount_price != null) {
                    $cart->price = $product->discount_price * $request->quantity;
                } else {
                    $cart->price = $product->price * $request->quantity;
                }
    
                $cart->image = $product->image;
                $cart->product_id = $product->id;
    
                $cart->quantity = $request->quantity;
                $cart->save();
    
                Alert::success('Product added successfully', 'Product is added into the cart');
    
                return redirect()->back();
            }
        } else {
            return redirect('login')->with('message', 'Please log in and register before placing an order');
        }
    }
    

    public function cart()
    {
        
        $user= auth()->user();
        $cart = Cart::where('email',$user->email)->get();
        $count=Cart::where('user_id',Auth::id())->count();
        return view('home.cart',compact('count','cart'));
    }

    public function remove_cart($id)
    {
        $cart=Cart::find($id);
        $cart->delete();
        return redirect()->back()->with('success','Product removed from cart successfully');
    }

    // public function updateCart(Request $request)
    // {
    //     $itemIds = $request->input('itemId');
    //     $quantities = $request->input('quantity');

    //     foreach ($itemIds as $index => $itemId) {
    //         // Find the cart item in the database
    //         $cartItem = Cart::find($itemId);

    //         if ($cartItem) {
    //             // Update the quantity
    //             $cartItem->quantity = $quantities[$index];
    //             $cartItem->total_price = $cartItem->price * $quantities[$index];
    //             $cartItem->save();
    //         }
    //     }

    //     // Redirect back to the cart page or any other appropriate page
    //     return redirect()->back()->with('success', 'Cart items updated successfully');
    // }

    public function show_order()
    {
        if(Auth::id())
        {
            $user= Auth::user();
            $user_id = $user->id;
            $order= Order::where('user_id','=',$user_id)->get();


            $count=Cart::where('user_id',Auth::id())->count();
            return view('home.order',compact('count','order'));
        }
        else{
            return redirect('login');
    }
}


public function cancel_order($id)
{
    $order = Order::find($id);
    $order->delivery_status='Cancelled';
    $order->save();
    return redirect()->back()->with('success','Order has been cancelled');
}

public function product_search(Request $request)
{
    $user= auth()->user();
    $count=Cart::where('email',$user->email)->count();
    $search_text = $request->search;
    $product = Product::where('title','LIKE',"%$search_text%")->paginate(3);
    return view('home.userpage',compact('product','count'));
}

public function product()
{
    $user= auth()->user();
    $count=Cart::where('email',$user->email)->count();
    $product=Product::paginate(3);
    return view('home.all_product',compact('product','count'));

}

public function search_product(Request $request)
{
    $user= auth()->user();
    $count=Cart::where('email',$user->email)->count();
    $search_text = $request->search;
    $product = Product::where('title','LIKE',"%$search_text%")->paginate(3);
    return view('home.all_product',compact('product','count'));
}


public function get_order()
{
    $count=Cart::where('user_id',Auth::id())->count();
    $orders = Order::where('user_id',Auth::id())->get();
    return view('home.order_page',compact('orders','count'));
}

public function view_order($id)
{
    $count=Cart::where('user_id',Auth::id())->count();
    $orders = Order::where('id',$id)->where('user_id',Auth::id())->first();
    return view('home.order_view',compact('orders','count'));
}
}