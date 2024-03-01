<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\donhang;
use App\Services\MailService;
use Illuminate\Http\Request;

class OrderStoreApiController extends Controller
{
    public function updateStatusCancel($id, Request $request)//Update => Bị từ chối
    {
        return Call::TryCatchResponseJson(function()use($id,$request){
            $donHang = donhang::where('MaDonhang',$id)->first(); 
            if(!isset($donHang))
                return ResponseJson::failed("Mã đơn hàng không tồn tại");       
            if($donHang->TrangThai!="Chờ xác thực" && $donHang->TrangThai!="Chờ xác nhận")
                return ResponseJson::failed("Trạng thái của đơn hàng này không còn từ chối được nữa");  
            $donHang->TrangThai = "Bị từ chối";
            $donHang->GhiChu = $request->ly_do;
            $donHang->save();       
            MailService::SendEmailRefuseOrder($donHang);
            return ResponseJson::success("Từ chối đơn hàng thành công");
        });        
    }
}
