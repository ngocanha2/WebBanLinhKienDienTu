<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\chitietdathang;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplyOrderApiController extends Controller
{
    public function show($id)
    {
        return Call::TryCatchResponseJson(function()use($id){
            $orderDetails = SupplierService::orderDetailsWithDeliveryStatus($id,["Đã xác nhận"]);
            // $chiTietPhieuDat = chitietdathang::where("SoPhieuDatHang",$id)->get();
            return ResponseJson::success(data:$orderDetails);
        });
    }
}
