<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietdathang;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\Premium;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Str;

class FeedbackService
{
    public static function createFeedback($maDonHang,$maHang,$feedback)
    {    
        $user = auth()->user();
        $donHang = donhang::find($maDonHang);
        if(!isset($donHang))
            return ResponseJson::error("Mã đơn hàng không tồn tại");
        if($donHang->TrangThai != "Đã giao")
            return ResponseJson::error("Đơn hàng chưa được phép đánh giá");
        if($donHang->MaKH != $user->MaKH)
            return ResponseJson::error("Bạn không có quyền đánh giá đơn hàng này");
        $chiTietDonHang = chitietdonhang::where("MaDonhang",$maDonHang)
                                        ->where("MaHang",$maHang);     
        $data = $chiTietDonHang->first();                                   
        if(!isset($data))
            return ResponseJson::error("Chi tiết đơn hàng không tồn tại");
        $data = [
            "MucDoHaiLong"=>$feedback["MucDoHaiLong"],
            "NoiDungDanhGia"=>$feedback["NoiDungDanhGia"],
            "AnDanh"=> $feedback["AnDanh"] == "true",
            "NgayDanhGia"=>Carbon::now(),
        ];
        $chiTietDonHang->update($data);
        // $chiTietDonHang->MucDoHaiLong = $feedback["MucDoHaiLong"];
        // $chiTietDonHang->NoiDungDanhGia = $feedback["NoiDungDanhGia"];
        // $chiTietDonHang->AnDanh = $feedback["AnDanh"] ?? false;
        // $chiTietDonHang->NgayDanhGia = Carbon::now();
        // $chiTietDonHang->save();
        return ResponseJson::success(data:$chiTietDonHang);
    }   

}

