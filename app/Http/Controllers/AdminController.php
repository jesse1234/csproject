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
use App\Models\OrderItems;
use App\Models\User;
use App\Models\Transaction;
use App\Models\StkRequest;
use Illuminate\Support\Facades\Storage;
use PDF;
use Notification;
use App\Notifications\EmailNotification;
use App\Charts\VendorChart;
use RealRashid\SweetAlert\Facades\Alert;


class AdminController extends Controller
{
    public function view_category()
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $total_product= Product::all()->count();
            $total_order= Order::all()->count();
            $data=category::all();
            return view('admin.category',compact('data','total_product','total_order'));
        }
        else
        {
            return redirect()->back()->with('success', "Please wait for account approval by admin");
        };
    }

    public function add_category(Request $request)
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {

            $data = new Category;
            $data->category_name = $request->category_name;
            $data->save();
            return redirect()->back()->with('message','Category added successfully');
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    
    }

    public function delete_category($id)
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $data = category::find($id);
            $data->delete();

            Alert::warning('Are you sure you want to delete this category');
            return redirect()->back()->with('message','Category deleted successfully');
            
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
       
    }

    public function view_product()
{
    if (Auth::guard('admin')->check() && Auth::guard('admin')->user()->status == 'approved') {
        $vendorId = Auth::guard('admin')->user()->id;
        $products = Product::where('vendor_id', $vendorId)->get();
        $total_product = $products->count();
        $total_order = Order::all()->count();
        return view('admin.add_product', compact('total_product', 'total_order', 'products'));
    } else {
        return redirect()->route('admin.login')->with('info', "Please login first");
    }
}

    public function add_product(Request $request)
    {

        if(Auth::guard('admin')->id())
        {
            $vendor= Auth::guard('admin')->user();
            $vendors = $vendor->id;


            $product = new Product;
            $product->title = $request->title;
            $product->description = $request->description;
            
            $image = $request->product_image;
            $imagename=time().'.'.$image->getClientOriginalExtension();
            $request->product_image->move('product',$imagename);
    
            $image_3d = $request->image_3d;
            $image_name=time().'.'.$image_3d->getClientOriginalExtension();
            $request->image_3d->move('product',$image_name);
    
            $product->image= $imagename;
            $product->image_3d = $image_name;
            
            $product->category_id = $request->category_id;
            $product->stock = $request->stock;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $product->vendor_id = $vendors;
        
            $product->save();
            return redirect()->back()->with('message','Product added successfully');
            
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        
    }

    public function show_product()
    {

        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $total_product= Product::all()->count();
            $total_order= Order::all()->count();
            $vendorId = Auth::guard('admin')->user()->id;
            $product = Product::where('vendor_id', $vendorId)->get();
        return view('admin.show_product', compact('product','total_product','total_order'));
            
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    }

    public function delete_product($id)
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            Alert::warning('Are you sure you want to delete this product');
            $product = Product::find($id);
            
            $product->delete();
            
            return redirect()->back()->with('message','Product deleted successfully');
                
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        }


        public function delete_order($id)
        {
            if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
            {
                
                $order = Order::find($id);
                
                $order->delete();
                Alert::warning('Are you sure you want to delete this order');
                return redirect()->back()->with('message','Order deleted successfully');
                    
            }
            else
            {
                return redirect()->route('admin.login')->with('info', "Please login first");
            };
            }

    public function update_product($id)
    {

        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $total_product= Product::all()->count();
            $total_order= Order::all()->count();
            $product = Product::find($id);
            return view('admin.update_product',compact('product','total_product','total_order'));    
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    }

    public function update_product_confirm(Request $request,$id)
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
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
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        
       }

    public function vendor_details()
    {
        if(Auth::guard('admin')->id() )
        {
            
            return view('admin.vendor_details');
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        
    }

    public function vendor_input(Request $request)
    {

        if(Auth::guard('admin')->id())
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
    

        return redirect()->back()->with('message','Your account will be activated after your details are reviewed');
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
       
    }

    public function show_order_table()
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $total_product= Product::all()->count();
            $total_order= Order::all()->count();
            $order = Order::all();
            return view('admin.orders_table',compact('order','total_product','total_order'));
           
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        
    }

    public function delivered($id)
    {
        if(Auth::guard('admin')->id() )
        {
            $order= Order::find($id);
            $order->delivery_status='Delivered';
            $order->save();
            return redirect()->back()->with('success','Order delivered successfully');
            }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    }

    public function print_pdf($id)
    {
        if(Auth::guard('admin')->id())
        {
            $order = Order::find($id);
            $pdf = PDF::loadView('admin.pdf',compact('order'));
            return $pdf->download('order_details.pdf');
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
        
    }

    public function send_email($id)
    {
        if(Auth::guard('admin')->id())
        {
            $total_product= Product::all()->count();
            $total_order = Order::all()->count();
            $order = Order::find($id);
            return view('admin.email_info',compact('order','total_product','total_order'));    
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    }

    public function send_user_email(Request $request, $id)
{
    if(Auth::guard('admin')->id())
    {
        $order=Order::find($id);
        $details=[
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'file' => $request->file('attachment')->getPathname(), // Get the file attachment from the request
            'url' => $request->url,
            'button' => $request->button,
            'lastline' => $request->lastline,
        ];
        Notification::send($order, new EmailNotification($details));

        return redirect()->back()->with("success", 'Email sent successfully');
    }
    else
    {
        return redirect()->route('admin.login')->with('info', "Please login first");
    }
}


    public function searchdata(Request $request)
    {
        if(Auth::guard('admin')->id()  && Auth::guard('admin')->user()->status == 'approved')
        {
            $total_product= Product::all()->count();
            $total_order= Order::all()->count();
        $searchText = $request->search;
        $order = Order::where('name' ,'LIKE',"%$searchText%")->orWhere('email' ,'LIKE',"%$searchText%")->orWhere('product_title' ,'LIKE',"%$searchText%")->orWhere('region' ,'LIKE',"%$searchText%")->orWhere('address' ,'LIKE',"%$searchText%")->get();
        return view('admin.orders_table',compact('order','total_product','total_order'));
        }
        else
        {
            return redirect()->route('admin.login')->with('info', "Please login first");
        };
    }

    public function vendor_chart(Request $request)
{
    $total_product= Product::all()->count();
    $total_order= Order::all()->count();

    $vendor = Order::pluck('total_price','created_at');
    $chart = new VendorChart;
    $chart->labels($vendor->keys());
    $chart->dataset('Order sales','line',$vendor->values())->backgroundColor('red');

    $user = User::pluck('id','created_at')->toArray();
    $userCounts = array_count_values($user);
    $user_chart = new VendorChart;
    $user_chart->labels(array_keys($userCounts));
    $user_chart->dataset('Order sales', 'bar', array_values($userCounts))->backgroundColor('grey');

    $approvedCount = Vendor::where('status', 'approved')->pluck('id', 'created_at')->groupBy('created_at')->map(function ($item) {
        return count($item);
    })->toArray();

    $pendingCount = Vendor::where('status', 'pending')->pluck('id', 'created_at')->groupBy('created_at')->map(function ($item) {
        return count($item);
    })->toArray();

    $status_chart = new VendorChart;
    $status_chart->labels(array_keys($approvedCount));

    $status_chart->dataset('Approved', 'bar', array_values($approvedCount))->color('green');
    $status_chart->dataset('Pending', 'bar', array_values($pendingCount))->color('orange');
    
    $total_vendors = Vendor::pluck('id', 'created_at')->groupBy('created_at')->map(function ($item) {
        return count($item);
    });

    $total_users = User::pluck('id', 'created_at')->groupBy('created_at')->map(function ($item) {
        return count($item);
    });

    $total_chart = new VendorChart;
    $total_chart->labels($total_vendors->keys()->toArray());
    $total_chart->dataset('Total Vendors', 'bar', $total_vendors->values()->toArray())->backgroundColor('blue');
    $total_chart->dataset('Total Users', 'bar', $total_users->values()->toArray())->backgroundColor('green');

    $product = Product::pluck('price','title');
    $product_chart = new VendorChart;
    $product_chart->labels($product->keys());
    $product_chart->dataset('Product prices','line',$product->values())->backgroundColor('grey');

    $discount_product = Product::pluck('discount_price','title');
    $discount_chart = new VendorChart;
    $discount_chart->labels($discount_product->keys());
    $discount_chart->dataset('Product discount prices','bar',$discount_product->values())->color('orange');

    return view('admin.detail_charts',compact('chart','user_chart','status_chart','total_chart','product_chart','discount_chart','total_product','total_order'));
}

public function transactions_table()
{
    $total_product= Product::all()->count();
    $total_order= Order::all()->count();
    $transaction = Transaction::all();
    return view('admin.transactions',compact('total_product','total_order','transaction'));
}

public function stk_table()
{
    $total_product= Product::all()->count();
    $total_order= Order::all()->count();
    $stk = StkRequest::all();
    return view('admin.stk_table',compact('total_product','total_order','stk'));
}


public function showForgotForm()
    {
        return view('admin.forgot');
    }

public function sendResetLink(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:vendors,email'
    ]);

    $token = Str::random(64);
    \DB::table('password_resets')->insert([
        'email' => $request->email,
        'token' => $token,
        'created_at' => Carbon::now(),
    
    ]);

    $action_link = route('admin.reset.password.form',['token' => $token, 'email' => $request->email]);
    $body = "We have received a request to reset the password for your account associated with".$request->email.". Click the link below to reset your password";
    
    \Mail::send('email-forgot',['action_link' => $action_link, 'body' => $body], function($message) use ($request){
        $message->from('jesse.kamau@strathmore.edu','Website Name');
        $message->to($request->email,'Your name')
                ->subject('Reset Password');
    });

    return back()->with('success','We have emailed the link to your account');
}

public function showResetForm(Request $request, $token = null)
{
    return view('admin.reset')->with(['token' => $token, 'email' => $request->email]);
}

public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:vendors,email',
        'password' => 'required|min:8|confirmed',
        'password_confirmation' => 'required'
    ]);

    $check_token = \DB::table('password_resets')->where([
        'email' => $request->email,
        'token' => $request->token,
    ])->first();

    if(!$check_token)
    {
        return back()->withInput()->with('fail', 'Invalid token');
    }
    else{
        Vendor::where('email',$request->email)->update([
            'password' => \Hash::make($request->password)
        ]);

        \DB::table('password_resets')->where([
            'email' => $request->email
        ])->delete();

        return redirect()->route('admin.login')->with('message','Your password has successfully changed');
    }


}

}
