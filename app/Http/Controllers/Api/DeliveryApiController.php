<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Services\DeliveryService;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class DeliveryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
            return DeliveryService::gets($request);
        });
    }    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 1;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Call::TryCatchResponseJson(function()use($id){
            return DeliveryService::show($id);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return 3;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,Request $request)
    {
        return Call::TryCatchResponseJson(function()use($id,$request){
            return DeliveryService::cancel($id,$request->LyDo);
        });
    }
    public function confirmStatus($soPhieuGiao)
    {        
        return Call::TryCatchResponseJson(function()use($soPhieuGiao){
            return DeliveryService::confirmStatus($soPhieuGiao);
        });    
    }    
    public function orderDetailsWithDeliveryStatusWaitingConfirm($orderNumber)
    {
        // cái này ch có xài
        return Call::TryCatchResponseJson(function()use($orderNumber){{            
            $orderDetails = SupplierService::orderDetailsWithDeliveryStatus($orderNumber,["Chờ xác nhận"]);
            return ResponseJson::success(data:$orderDetails);
        }});        
    }
}
