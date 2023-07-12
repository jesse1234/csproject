<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Vendor;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.admin_login');
    }

    public function dashboard()
    {
        return view('superadmin.admin_dashboard');
    }

    public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::guard('superadmin')->attempt($credentials)) {
        $user = Auth::guard('superadmin')->user();

        if ($user->remember_token === null) {
            $user->setRememberToken(Str::random(60));
            $user->save();
        }

        return redirect()->route('superadmin.dashboard')->with('success', 'Login successful');
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
        return view('superadmin.vendor_table', compact('vendors'));
    }

    public function approve($id)
{
    $vendor = Vendor::findOrFail($id);
    $vendor->status = 'Approved';
    $vendor->save();

    // Optionally, you can send a notification to the vendor here.

    return redirect()->back()->with('success', 'Vendor approved successfully.');
}
}
