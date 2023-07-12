<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\Cart;
use App\Models\User;
use Str;
use Session;
use Mpesa;

class MpesaController extends Controller
{
//     public function stkPushSimulation()
//     {
//         $mpesa= new \Safaricom\Mpesa\Mpesa();
//         $BusinessShortCode = 174379; 
//         $LipaNaMpesaPasskey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; 
//         $TransactionType='CustomerPayBillOnline';
//         $Amount='1'; 
//         $PartyA='254796347604';
//         $PartyB=174379; 
//         $PhoneNumber='254796347604';
//         $CallBackURL=' https://6002-105-163-1-141.ngrok-free.app/api/mpesa/stkpush/response'; 
//         $AccountReference='Artifact Inc.'; 
//         $TransactionDesc='Lipa Na MPESA'; 
//         $Remarks='Thanks for paying';


// $stkPushSimulation=$mpesa->STKPushSimulation(
//     $BusinessShortCode, 
//     $LipaNaMpesaPasskey, 
//     $TransactionType, 
//     $Amount, 
//     $PartyA, 
//     $PartyB, 
//     $PhoneNumber, 
//     $CallBackURL, 
//     $AccountReference, 
//     $TransactionDesc, 
//     $Remarks
//         );

//         dd($stkPushSimulation);
//     }

    public function stkSimulation(Request $request, $totalprice, $user_id)
    {
        $user = User::find($user_id);
        $cart = Cart::where('user_id',$user->id)->get();
        $transId = Str::random().$totalprice.$user_id;
        $transexists = Transaction::where('user_id', $user_id)->where('status', 0)->first();
        if($transexists){
            session()->flash('error','You still have a pending transaction!');
            return redirect()->route('dashboard')->with('success', 'There is a pending transaction');
        }
        $trans = new Transaction;
        $trans->user_id = $user_id;
        $trans->transaction_id =$transId;
        $trans->cart = json_encode($cart);
        $trans->save();
        $phone =  $request->phone;
        $formatedPhone = substr($phone, 1);//726582228
        $code = "254";
        $phoneNumber = $code.$formatedPhone;//254726582228

        $mpesa= new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode=174379;
        $LipaNaMpesaPasskey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType="CustomerPayBillOnline";
        $Amount=$totalprice;
        $PartyA=$phoneNumber;
        $PartyB=174379;
        $PhoneNumber=$phoneNumber;
        $CallBackURL="https://6002-105-163-1-141.ngrok-free.app/api/mpesa/stkpush/response";
        $AccountReference="Artifact Inc Payment";
        $TransactionDesc="lipa Na M-PESA web development";
        $Remarks="Thank for paying!";
        
        $stkPushSimulation=$mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        
        
        Cart::where('user_id', $user->id)->delete();
        return redirect()->back()->with('success', 'Order made successfully');
    }

    public function resData(Request $request)
    {
        $response = json_decode($request->getContent());
        $resData =  $response->Body->stkCallback->CallbackMetadata;
        $reCode =$response->Body->stkCallback->ResultCode;
        $resMessage =$response->Body->stkCallback->ResultDesc;
        $amountPaid = $resData->Item[0]->Value;
        $mpesaTransactionId = $resData->Item[1]->Value;
        $paymentPhoneNumber =$resData->Item[4]->Value;
        //replace the first 254 with 0
        $formatedPhone = str_replace("254","0",$paymentPhoneNumber);
        $user = Cart::where('phone', $formatedPhone)->first();
        $trans = Transaction::where('user_id', $user->id)->where('status', 0)->first();
        $transId = $trans->id;
        $payment = new Payment;
        $payment->amount = $amountPaid;
        $payment->trans_id =  $transId;
        $payment->user_id = $user->id;
        $payment->mpesa_trans_id = $mpesaTransactionId;
        $payment->phone = $formatedPhone;
        $payment->save();
        $trans->status = 1;
        $trans->save();

    }

}
