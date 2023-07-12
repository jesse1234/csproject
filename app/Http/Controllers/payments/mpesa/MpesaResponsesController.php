<?php

namespace App\Http\Controllers\payments\mpesa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MpesaResponsesController extends Controller
{
    public function validation(Request $request)
    {
        Log::info('Validation endpoint hit');
        Log::info($request->all());

        return[
            'ResultCode' => 0,
            "ResultDesc" => "The service request has been accepted successfully.",
            'ThirdPartyTransID' => rand(3000)
        ];
    }

    public function confirmation(Request $request)
    {
        Log::info('Confirmation endpoint hit');
        Log::info($request->all());
    }

    public function stkPush(Request $request)
    {
        Log::info('STK Push endpoint hit');
        Log::info($request->all());
    }
}

