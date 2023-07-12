<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\StkRequest;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Str;
use Session;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    public function token(){
        $consumerKey='EAnUa7M5m8I9UGJgv4l6R7jyHAtnsA4J';
        $consumerSecretKey='4VaYprAqWR05kTgk';
        $url='https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $response=Http::withBasicAuth($consumerKey,$consumerSecretKey)->get($url);
        return $response['access_token'];

    }

    public function initiateStkPush(Request $request, $totalprice, $user_id)
    {
        $user = User::find($user_id);
        $cart = Cart::where('user_id',$user->id)->get();
        $transId = Str::random().$totalprice.$user_id;
        
        $trans = new Transaction;
        $trans->user_id = $user_id;
        $trans->transaction_id =$transId;
        $trans->cart = json_encode($cart);
        $trans->save();
        $phone =  $request->phone;
        $formatedPhone = substr($phone, 1);//726582228
        $code = "254";
        $phoneNumber = $code.$formatedPhone;//254726582228

        $accessToken=$this->token();
        $url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $passKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $BusinessShortCode=174379;
        $Timestamp=Carbon::now()->format('YmdHms');
        $password=base64_encode($BusinessShortCode.$passKey.$Timestamp);
        $TransactionType='CustomerPayBillOnline';
        $Amount=$totalprice;
        $PartyA=$phoneNumber;
        $PartyB=174379;
        $PhoneNumber=$phoneNumber;
        $CallbackUrl='https://6002-105-163-1-141.ngrok-free.app/payments/stkcallback';
        $AccountReference='Artifact Inc.';
        $TransactionDesc= 'Artifact Inc.';
        

        try{

        
        $response=Http::withToken($accessToken)->post($url,[
            'BusinessShortCode' => $BusinessShortCode,
            'Password'=>$password,
            'Timestamp'=>$Timestamp,
            'TransactionType'=>$TransactionType,
            'Amount'=>$Amount,
            'PartyA'=>$PartyA,
            'PartyB'=>$PartyB,
            'PhoneNumber'=>$PhoneNumber,
            'CallBackURL'=>$CallbackUrl,
            'AccountReference'=>$AccountReference,
            'TransactionDesc'=>$TransactionDesc,
        ]);

    }catch(Throwable $e){
        return $e->getMessage();
    }
    //return $response;
    $res= json_decode($response);
    $ResponseCode=$res->ResponseCode;

    if($ResponseCode==0)
    {
        $MerchantRequestID = $res->MerchantRequestID;
        $CheckoutRequestID = $res->CheckoutRequestID;
        $CustomerMessage = $res->CustomerMessage;

        //save response to DB
        $payment=new StkRequest;
        $payment->phone=$PhoneNumber;
        $payment->amount=$Amount;
        $payment->reference=$AccountReference;
        $payment->description=$TransactionDesc;
        $payment->MerchantRequestID=$MerchantRequestID;
        $payment->CheckoutRequestID=$CheckoutRequestID;
        $payment->status='Requested';
        $payment->save();

    }

    Cart::where('user_id', $user->id)->delete();
        return redirect()->back()->with('success', 'Order made successfully');
    }

    public function stkCallback()
    {
        $data=file_get_contents('php://input');
        Storage::disk('local')->put('stk.txt',$data);

        $response = json_decode($data);
        $ResultCode=$response->Body->stkCallback->ResultCode;

        if($ResultCode == 0 )
        {
            $MerchantRequestID=$response->Body->stkCallback->MerchantRequestID;
            $CheckoutRequestID=$response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc=$response->Body->stkCallback->ResultDesc;
            $Amount=$response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $MpesaReceiptNumber=$response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            //$Balance=$response->Body->stkCallback->CallbackMetadata->Item[2]->Value;
            $TransactionDate=$response->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $PhoneNumber=$response->Body->stkCallback->CallbackMetadata->Item[3]->Value;

            $payment = StkRequest::where('CheckoutRequestID' ,$CheckoutRequestID)->firstOrfail();
            $payment->status='Paid';
            $payment->TransactionDate=$TransactionDate;
            $payment->MpesaReceiptNumber=$MpesaReceiptNumber;
            $payment->ResultDesc=$ResultDesc;
            $payment->save();


        }
        else
        {
            $CheckoutRequestID=$response->Body->stkCallback->CheckoutRequestID;
            $ResultDesc=$response->Body->stkCallback->ResultDesc;
            $payment = StkRequest::where('CheckoutRequestID' ,$CheckoutRequestID)->firstOrfail();
            $payment->ResultDesc=$ResultDesc;
            $payment->status='Failed';
            $payment->save();
        }
    }

    public function stkQuery()
    {
        $accessToken=$this->token();
        $BusinessShortCode=174379;
        $PassKey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $url='https://sandbox.safaricom.co.ke/mpesa/stkpushquery/v1/query';
        $Timestamp=Carbon::now()->format('YmdHis');
        $Password=base64_encode($BusinessShortCode.$PassKey.$Timestamp);
        $CheckoutRequestID='ws_CO_09072023185321614796347604';

        $response=Http::withToken($accessToken)->post($url,[
            'BusinessShortCode' => $BusinessShortCode,
            'Timestamp' => $Timestamp,
            'Password' => $Password,
            'CheckoutRequestID' =>$CheckoutRequestID
        ]);

        return $response;
    }

}
