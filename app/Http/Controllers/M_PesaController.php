<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpesa;
use App\Models\User;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Payment;
use Str;
use Session;


class M_PesaController extends Controller
{

   

    public function stk_simulation()
    {
        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = '1';
        $PartyA = '254796347604';
        $PartyB = '174379';
        $PhoneNumber = '254796347604';
        $CallBackURL ='https://artifact-inc-shop/payments/stkcallback'; 
        $AccountReference='AccountReference'; 
        $TransactionDesc ='TransactionDesc';
        $Remarks = 'Thank you for your payment.';
  
        $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode, $LipaNaMpesaPasskey, 
        $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);

         dd($stkPushSimulation);

        sleep(10);

        // $notification = array(
    	// 	'message' => 'Thank you, your payment has been received.',
    	// 	'alert-type' => 'success'
    	// );

    	// return redirect()->route('dashboard')->with($notification);
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
        $user = User::where('phone', $formatedPhone)->first();
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