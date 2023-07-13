<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Vendor;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Charts\VendorChart;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.admin_login');
    }

    public function dashboard()
    {
        $user_count = User::all()->count();
    $vendor_count = Vendor::all()->count();
        return view('superadmin.admin_dashboard',compact('user_count','vendor_count'));
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('superadmin')->attempt($credentials)) {
        $user = Auth::guard('superadmin')->user();
        $user_count = User::all()->count();
    $vendor_count = Vendor::all()->count();

        if ($user->remember_token === null) {
            $user->setRememberToken(Str::random(60));
            $user->save();
        }

        return redirect()->route('superadmin.dashboard',compact('user_count','vendor_count'))->with('success', 'Login successful');
    } else {
        return back()->with('error', 'Invalid email or password');
    }
}

    public function AdminLogout()
    {
        Auth::guard('superadmin')->logout();
        return redirect()->route('login_form')->with('error','Logout successful');
    }

    public function showForgotForm()
    {
        return view('superadmin.forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:super_admins,email'
        ]);

        $token = Str::random(64);
        \DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        
        ]);

        $action_link = route('reset.password.form',['token' => $token, 'email' => $request->email]);
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
        return view('superadmin.reset')->with(['token' => $token, 'email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:super_admins,email',
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
            Admin::where('email',$request->email)->update([
                'password' => \Hash::make($request->password)
            ]);

            \DB::table('password_resets')->where([
                'email' => $request->email
            ])->delete();

            return redirect()->route('login_form')->with('info','Your password has successfully changed');
        }
    }

    public function vendor_approve()
    {
        $vendors = Vendor::all();
        $user_count = User::all()->count();
    $vendor_count = Vendor::all()->count();
        return view('superadmin.vendor_table', compact('vendors','vendor_count','user_count'));
    }

    public function approve($id)
{
    $vendor = Vendor::findOrFail($id);
    $vendor->status = 'Approved';
    $vendor->save();

    // Optionally, you can send a notification to the vendor here.

    return redirect()->back()->with('success', 'Vendor approved successfully.');
}

public function user_chart(Request $request)
{
    $user_count = User::all()->count();
    $vendor_count = Vendor::all()->count();

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

    return view('superadmin.vendor_chart',compact('chart','user_chart','status_chart','total_chart','product_chart','discount_chart','user_count','vendor_count'));
}

public function show_users_table()
{
    $user = User::all();
    $user_count = User::all()->count();
    $vendor_count = Vendor::all()->count();
    return view('superadmin.users_table',compact('user','user_count','vendor_count'));
}




}
