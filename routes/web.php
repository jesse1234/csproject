<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\PolicyController;
use App\Models\Post;
use App\Models\Product;
// use Barryvdh\DomPDF\PDF;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;



//Route::get('/pdf', function () {
 //   $data['product'] = Product::get();
 //   $pdf = PDF::loadView('pdf', $data);
//    return $pdf->download('abc.pdf');
//    return view('welcome');
//});

//Route::get('/debug', function () {
//   $data = Product::get();
 //   return view('debug', compact('data'));
//});

Route::group(['middleware' => 'prevent-back-history'],function(){

Route::get('/', [HomeController::class,'index']);

Route::get('/dashboard', [HomeController::class,'dashboard'])->middleware(['auth','verified'])->name('dashboard');

Route::get('/welcome', [HomeController::class,'welcome']);
// Route::post('get-token',[MpesaController::class,'getAccessToken']);
// Route::post('register-urls',[MpesaController::class,'registerURLS']);
// Route::post('simulate',[MpesaController::class,'simulateTransaction']);
// Route::post('stkpush',[MpesaController::class,'stkPush']);
// Route::get('/stk/push/simulation',[App\Http\Controllers\Api\MpesaController::class,'stkPushSimulation']);
// Route::get('stk',function(){
//     return view('stk');
// });

Route::get('/stk/push/simulation',[MpesaController::class,'stkPushSimulation']);
Route::post('/transaction/new/{totalprice}/{user_id}', [MpesaController::class, 'stkSimulation'])->name('checkout.pay')->middleware('auth');


//Super Admin route
Route::prefix('superadmin')->group(function(){
    Route::get('/login', [SuperAdminController::class,'index'])->name('login_form');
    Route::post('/login/owner', [SuperAdminController::class,'login'])->name('superadmin.login');
    Route::get('/dashboard', [SuperAdminController::class,'dashboard'])->name('superadmin.dashboard')->middleware('superadmin');
    Route::get('/logout', [SuperAdminController::class,'Adminlogout'])->name('superadmin.logout')->middleware('superadmin');
    Route::get('/password/forgot', [SuperAdminController::class,'showForgotForm'])->name('forgot.password.form');
    
    Route::post('/password/forgot/link', [SuperAdminController::class,'sendResetLink'])->name('password.link');
    
    Route::get('/password/forgot/{token}', [SuperAdminController::class,'showResetForm'])->name('reset.password.form');
    Route::post('/password/forgot', [SuperAdminController::class,'resetPassword'])->name('reset.password');
    Route::get('/vendor_approve', [SuperAdminController::class,'vendor_approve'])->name('vendor.approve');
    Route::post('vendors/approve/{id}', [SuperAdminController::class,'approve'])->name('vendors.approve');

});


    Route::get('/admin/vendor_details', [AdminController::class,'vendor_details']);
    Route::post('vendor_details', [AdminController::class,'vendor_input'])->name('vendor.details');
    Route::get('/admin/import_details', [ProductController::class, 'importProducts'])->name('import');
    Route::post('/import-products', [ProductController::class,'uploadProducts'])->name('import.products');
    Route::get('/view_product',[AdminController::class,'view_product']);
    Route::get('/show_product',[AdminController::class,'show_product']);
    Route::get('/delete_product/{id}',[AdminController::class,'delete_product']);
    Route::get('/update_product/{id}',[AdminController::class,'update_product']);
    Route::post('/update_product_confirm/{id}',[AdminController::class,'update_product_confirm']);
    
    Route::get('/show_order',[AdminController::class,'show_order']);
    Route::get('/delivered/{id}', [AdminController::class,'delivered']);
    Route::get('/print_pdf/{id}', [AdminController::class,'print_pdf']);
    Route::get('/send_email/{id}', [AdminController::class,'send_email']);
    Route::post('/send_user_email/{id}', [AdminController::class,'send_user_email']);
    Route::get('/search', [AdminController::class,'searchdata']);


    Route::get('/product_details/{id}',[HomeController::class,'product_details']);

    Route::post('/add_to_cart/{id}', [HomeController::class, 'add_to_cart'])->name('add_to_cart');
    Route::get('cart', [HomeController::class, 'cart'])->name('cart');
    Route::get('/remove_cart/{id}', [HomeController::class, 'remove_cart']);
    Route::post('/update_cart', [HomeController::class, 'updateCart'])->name('cart.update');

    Route::post('/checkout/{totalprice}', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/{totalprice}', [CheckoutController::class, 'checkout_page'])->name('checkout.submit');
    Route::get('/pay_method',[CheckoutController::class,'payment_method'])->name('payment_method');
    Route::get('/mpesa/{totalprice}',[CheckoutController::class,'mpesa_form'])->name('mpesa.form');
    
   Route::controller(PaymentController::class)->prefix('payments')->as('payments')->group(function()
{
    Route::get('/initiatepush','initiateStkPush')->name('initiatepush');
    Route::post('/stkcallback','stkCallback')->name('stkcallback');
    Route::get('/stkquery','stkQuery')->name('stkquery');
    Route::post('/mpesa/initiate/{totalprice}/{user_id}', [PaymentController::class, 'initiateStkPush'])->name('mpesa.initiate');

 });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin_auth.php';


//Route::get('gate', [AuthorizationController::class, 'index'])->name('gate')->middleware(['can:isAdmin']);

