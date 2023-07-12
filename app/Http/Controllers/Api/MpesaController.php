<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Mpesa;

class MpesaController extends Controller
{
    // public function genrateAccessToken()
    // {
    //     $consumer_key='EAnUa7M5m8I9UGJgv4l6R7jyHAtnsA4J';
    //     $consumer_secret='4VaYprAqWR05kTgk';
    //     $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    //     $credentials = base64_encode($consumer_key.":".$consumer_secret);

    //     $curl = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic'.$credentials));
    //     curl_setopt($curl, CURLOPT_HEADER,false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

    //     $curl_response = curl_exec($curl);
    //     $access_token = json_decode($curl_response);
    //     return $access_token->access_token;
    // }

    // public function STKPush()
    // {
    //     $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    //     $BusinessShortCode = 174379;
    //     $passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
    //     $timestamp = Carbon::now()->format('YmdHms');;

    //     $password = base64_encode($BusinessShortCode.$passkey.$timestamp);
    //     $Amount = 1;
    //     $PartyA= 254796347604;
    //     $PartyB= 174379;

    //     $curl = curl_init();
    //     curl_setopt($curl, CURLOPT_URL,$url );
    //     curl_setopt($curl,CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorisation:Bearer ACCESS_TOKEN'));
        
    //     $curl_post_data= array(
    //         "BusinessShortCode"=> $BusinessShortCode,
    //         "Password"=> $password,
    //         "Timestamp"=> $timestamp,
    //         "TransactionType"=> "CustomerPayBillOnline",
    //         "Amount"=> $Amount,
    //         "PartyA"=> $PartyA,
    //         "PartyB"=> $PartyB,
    //         "PhoneNumber"=> $PartyA,
    //         "CallBackURL"=> " https://786a-105-163-1-141.ngrok-free.app/lipa-na-mpesa/",
    //         "AccountReference"=> "Artifact Inc.",
    //         "TransactionDesc"=> "Testing" 
    //     );

    //     $data_string = json_encode($curl_post_data);
    //     curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($curl,CURLOPT_POST,true);
    //     curl_setopt($curl,CURLOPT_POSTFIELDS, $data_string);

    //     $curl_response = curl_exec($curl);
    //     return $curl_response;
    // }

    public function stkPushSimulation()
    {
        $mpesa= new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode = 174379; 
        $LipaNaMpesaPasskey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; 
        $TransactionType='CustomerPayBillOnline';
        $Amount='1'; 
        $PartyA='254796347604';
        $PartyB=174379; 
        $PhoneNumber='254796347604';
        $CallBackURL; 
        $AccountReference='Artifact Inc.'; 
        $TransactionDesc='Lipa Na MPESA'; 
        $Remarks='Thanks for paying';


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

        dd($stkPushSimulation);
    }
}
