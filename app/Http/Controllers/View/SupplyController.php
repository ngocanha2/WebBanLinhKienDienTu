<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\chitietdathang;
use App\Models\phieudathang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplyController extends Controller
{
    public function getSupply(Request $request){
        $dataNCC =  DB::select("select * from nhacungcap");
       // $dataSupply =  DB::select("select * from nguonhang");
        $dataSupply = DB::table('nguonhang')
    ->join('hanghoa', 'nguonhang.MaHang', '=', 'hanghoa.MaHang')
    ->join('nhacungcap', 'nguonhang.MaNCC', '=', 'nhacungcap.MaNCC')
    ->select(
        'nguonhang.*',
        'hanghoa.*',
        'nhacungcap.*'
    )
    ->get();
    
      return view("supply.orderProduct",["NCCs"=>$dataNCC, "supplys"=>$dataSupply]);
    }        
    public function themHoaDon(Request $request)
    {
        //return response()->json(['SoPhieuDatHang' => $request->all()]);
        $user = Auth::guard("admin-api")->user();
        $hoadonData = $request->hoadonData;
        $hoaDon = phieudathang::create([
            "MaNCC"=>$hoadonData["MaNCC"],
            "MaNV"=>$user->MaNV,
            "TongSL"=>$hoadonData["TongSL"],
            "NgatDat"=>now(),
            "ThanhTien"=>$hoadonData["ThanhTien"],
        ]); 
        // new phieudathang();
        // $hoaDon->MaNCC = $hoadonData["MaNCC"];
        // $hoaDon->MaNV = $hoadonData["MaNV"];
        // $hoaDon->TongSL = $hoadonData["TongSL"];
        // $hoaDon->NgatDat = now();
        // $hoaDon->ThanhTien = $hoadonData["ThanhTien"];
        

        // Thêm các thông tin khác nếu cần
        // $hoaDon->save();

        // $chiTietData = $request->chiTietData;

        foreach ($request->chiTietData as $chiTiet) {
            $chiTietHoaDon = new chitietdathang();
            $chiTietHoaDon->SoPhieuDatHang = $hoaDon->SoPhieuDatHang;
            $chiTietHoaDon->MaHang = $chiTiet['MaHang'];
            $chiTietHoaDon->SoLuong = $chiTiet['SoLuong'];
            $chiTietHoaDon->DonGia = $chiTiet['DonGia'];
            // Thêm các thông tin khác nếu cần
            $chiTietHoaDon->save();
        }


        return response()->json(['SoPhieuDatHang' => $hoaDon->SoPhieuDatHang]);
    }

    public function themChiTietHoaDon(Request $request)
    {
        foreach ($request->chiTietData as $chiTiet) {
            $chiTietHoaDon = new ChiTietHoaDon();
            $chiTietHoaDon->SoPhieuDatHang = $chiTiet['SoPhieuDatHang'];
            $chiTietHoaDon->MaHang = $chiTiet['MaHang'];
            $chiTietHoaDon->SoLuong = $chiTiet['SoLuong'];
            $chiTietHoaDon->DonGia = $chiTiet['DonGia'];
            // Thêm các thông tin khác nếu cần
            $chiTietHoaDon->save();
        }

        return response()->json(['message' => 'Thêm chi tiết hóa đơn thành công']);
    }


    public function thongTinHoaDon($id){

        $dataPh = DB::table('phieudathang')
        ->join('nhanvien', 'phieudathang.MaNV','=','nhanvien.MaNV')
        ->join('nhacungcap','nhacungcap.MaNCC','=','phieudathang.MaNCC')->where('SoPhieuDatHang', $id)->first();
        
        $dataChiTiet = DB::table('chitietdathang')
        ->join('hanghoa', 'chitietdathang.MaHang', '=','hanghoa.MaHang')->where('SoPhieuDatHang', $id)->get();
        
        return view("supply.detailOrderProduct",["PhDatHangs"=>$dataPh, "CTPhDatHang"=>$dataChiTiet]);

    }
}
