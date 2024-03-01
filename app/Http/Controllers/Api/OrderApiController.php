<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function buildOrder(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
            return OrderService::buildOrder($request->ma_hangs);
        });
    }
    public function checkout()
    {
        return Call::TryCatchResponseJson(function(){
            return OrderService::checkout();
        });
    }
    public function submitOrder(Request $request)
    {
        return Call::TryCatchResponseJson(function() use($request){
            return OrderService::submitOrder($request->all());
        });
    }
}
