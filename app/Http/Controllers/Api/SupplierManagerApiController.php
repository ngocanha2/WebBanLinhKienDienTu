<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\chitietdathang;
use App\Models\chitietgiaohang;
use App\Models\phieudathang;
use App\Models\phieugiaohang;
use App\Services\SupplierService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierManagerApiController extends Controller
{
    
    public function handle($orderNumber,Request $request)
    {
        return Call::TryCatchResponseJson(function()use($orderNumber,$request){{
            $phieuDatHang= phieudathang::where("SoPhieuDatHang",$orderNumber)->first();            
            if(!isset($phieuDatHang))
                return ResponseJson::error("Phiếu đặt hàng không tồn tại");     
            $phieuGiaoHang = phieugiaohang::create([                
                'SoPhieuDatHang'=>$orderNumber,
                'NgayGiao'=>Carbon::now(),
                'TongSoLuong'=>0, 
                'TrangThai'=>"Chờ xác nhận",
                'ThanhTien'=>0,
            ]);            
            $data = [];
            $thanhTien = 0;
            $tongSoLuong = 0;
            foreach ($request->data as $item) {
                $soLuong = intval($item["SoLuong"]);
                array_push($data,[
                    "SoPhieuGiaoHang"=>$phieuGiaoHang->SoPhieuGiaoHang,
                    "MaHang"=>$item["MaHang"],
                    "SoLuong"=>$soLuong
                ]);                      
                $chiTietPhieuDat = chitietdathang::where("SoPhieuDatHang",$orderNumber)
                                                ->where("MaHang",$item["MaHang"])->first();
                $thanhTien += $chiTietPhieuDat->DonGia * $soLuong;
                $tongSoLuong += $soLuong;                
            }
            chitietgiaohang::insert($data);
            $phieuGiaoHang->ThanhTien = $thanhTien;
            $phieuGiaoHang->TongSoLuong = $tongSoLuong;
            $phieuGiaoHang->save();
            return ResponseJson::success("Tạo phiếu giao hàng thành công");
        }});     
    }
}
