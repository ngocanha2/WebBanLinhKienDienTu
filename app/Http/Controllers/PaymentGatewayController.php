<?php

namespace App\Http\Controllers;

use App\Services\MomoService;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function gatewayMomo(Request $request)
    {
        dd($request->all());
        return MomoService::gatewayMomo();
    }
}
