<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use PDF;
use Notification;
use App\Notifications\EmailNotification;

class AdminController extends Controller
{
    public function view_category()
    {
        $data=category::all();
        return view('admin.category',compact('data'));
    }

    public function add_category(Request $request)
    {
        $data = new Category;
        $data->category_name = $request->category_name;
        $data->save();
        return redirect()->back()->with('message','Category added successfully');
    }

    public function delete_category($id)
    {
        $data = category::find($id);
        $data->delete();
        return redirect()->back()->with('message','Category deleted successfully');
    }

    public function view_product()
    {
        return view('admin.add_product');
    }

    public function add_product(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->description = $request->description;
        
        $image = $request->product_image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->product_image->move('product',$imagename);

        $_3d_image = $request->_3d_image;
        $image_name=time().'.'.$_3d_image->getClientOriginalExtension();
        $request->_3d_image->move('product',$image_name);

        $product->image= $imagename;
        $product->_3d_image = $image_name;
        
        $product->category_id = $request->category_id;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
    
        $product->save();
        return redirect()->back()->with('message','Product added successfully');
    }

    public function show_product()
    {
        $product = Product::all();
        return view('admin.show_product', compact('product'));
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message','Product deleted successfully');
    }

    public function update_product($id)
    {
        $product = Product::find($id);
        return view('admin.update_product',compact('product'));
    }

    public function update_product_confirm(Request $request,$id)
    {
        
        $product = Product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;

        $image = $request->image;
        $imagename=time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);

        $product->image = $imagename;

        $image_3d = $request->image_3d;
        $image_name=time().'.'.$image_3d->getClientOriginalExtension();
        $request->image_3d->move('product',$image_name);

        $product->image_3d = $image_name;

        $product->category_id = $request->category_id;
        $product->stock = $request->stock;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->save();
        
        return redirect()->back()->with('message', 'Product updated successfully');
    }

    public function vendor_details()
    {
        return view('admin.vendor_details');
    }

    public function vendor_input(Request $request)
    {
        // Retrieve the authenticated vendor
        $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image'],
            'address' => ['required', 'string', 'max:255'],
        ]);
    
        // Retrieve the authenticated vendor
        $vendor = Auth::guard('admin')->user();
    
        // Update the vendor details in the database
        $vendor->update([
            'business_name' => $request->business_name,
            'address' => $request->address,
        ]);
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move('product', $imagename);
        
            $vendor->update(['image' => $imagename]);
        }
    

        return redirect()->back()->with('success','Your account will be activated after your details are reviewed');
    }

    public function show_order()
    {
        $order = Order::all();
        return view('admin.orders_table',compact('order'));
    }

    public function delivered($id)
    {
        $order= Order::find($id);
        $order->delivery_status='Delivered';
        $order->save();
        return redirect()->back()->with('success','Order delivered successfully');
    }

    public function print_pdf($id)
    {
        $order = Order::find($id);
        $pdf = PDF::loadView('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');
    }

    public function send_email($id)
    {
        $order = Order::find($id);
        return view('admin.email_info',compact('order'));
    }

    public function send_user_email(Request $request, $id)
    {
        $order=Order::find($id);
        $details=[
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'file' => $request->file,
            'url' => $request->url,
            'button' => $request->button,
            'lastline' => $request->lastline,

        ];
        Notification::send($order,new EmailNotification($details));

        return redirect()->back()->with("success", 'Email sent successfully');
    }

    public function searchdata(Request $request)
    {
        $searchText = $request->search;
        $order = Order::where('name' ,'LIKE',"%$searchText%")->orWhere('email' ,'LIKE',"%$searchText%")->orWhere('product_title' ,'LIKE',"%$searchText%")->orWhere('region' ,'LIKE',"%$searchText%")->orWhere('address' ,'LIKE',"%$searchText%")->get();
        return view('admin.orders_table',compact('order'));
    }
}
