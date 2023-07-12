<?php

namespace App\Http\Controllers\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MpesaController extends Controller
{
    public function genrateAccessToken()
    {
        $consumer_key='EAnUa7M5m8I9UGJgv4l6R7jyHAtnsA4J';
        $consumer_secret='4VaYprAqWR05kTgk';
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($consumer_key.":".$consumer_secret);

        $curl = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic'.$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);

        $curl_response = curl_exec($curl);
        $access_token = json_decode($curl_response);
        return $access_token;
    }
}
