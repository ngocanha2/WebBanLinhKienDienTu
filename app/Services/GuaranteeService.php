<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietdathang;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\hanghoa;
use App\Models\hoadonbaohanhsuachua;
use App\Models\Premium;
use App\Models\Role;
use App\Models\User;
use App\Models\yeucaubaohanh;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Str;

class GuaranteeService
{
    public static function all($maDonHang,$maHang)
    {
        $yeuCauBaoHanhs = yeucaubaohanh::select("yeucaubaohanh.*","hoadonbaohanhsuachua.*","HangHoa.TenHang")
                                    ->leftJoin("hoadonbaohanhsuachua","hoadonbaohanhsuachua.YeuCauBaoHanhId","=","yeucaubaohanh.id")
                                    ->join("hanghoa","hanghoa.MaHang","=","yeucaubaohanh.MaHang")
                                    ->where("MaDonHang",$maDonHang)
                                    ->where("yeucaubaohanh.MaHang",$maHang)->get();
        return ResponseJson::success(data:$yeuCauBaoHanhs);
    }
    public static function unprocessed($maDonHang,$maHang)
    {
        $yeuCauBaoHanh = yeucaubaohanh::select("MaDonHang","MaHang","DaXuLyBaoHanh","NgayYeuCau as NgayYeuCauBaoHanh","NguyenNhanBaoHanh","SoLuong as SoLuongBaoHanh","id")
                                    ->where("MaDonHang",$maDonHang)
                                    ->where("MaHang",$maHang)
                                    ->where("DaXuLy",false)
                                    ->first();
        return ResponseJson::success(data:$yeuCauBaoHanh);
    }
    public static function store($maDonHang,$maHang,$data)
    {            
        $donHang = donhang::find($maDonHang);
        if(!isset($donHang))
            return ResponseJson::error("Mã đơn hàng không tồn tại");
        $chiTietDonHang = chitietdonhang::where("MaDonHang",$maDonHang)
                                        ->where("MaHang",$maHang)->first();
        if(!isset($chiTietDonHang))
            return ResponseJson::error("Đơn hàng không tồn tại mặt hàng này");
        $yeuCauBaoHanh = yeucaubaohanh::create([
            'MaDonHang'=>$maDonHang,   
            'MaHang'=>$maHang,
            'NgayYeuCau'=>now(),        
            'NguyenNhanBaoHanh'=>$data["NguyenNhanBaoHanh"],
            'DaXuLy'=>false,
            'SoLuong'=>$data["SoLuong"],  
        ]);
        return ResponseJson::success(data:$yeuCauBaoHanh);
    }   
    public static function update($id,$data)
    {        
        $yeuCauBaoHanh = yeucaubaohanh::find($id);
        if(!isset($yeuCauBaoHanh)){
            return ResponseJson::error("Yêu cầu bảo hành này không tồn tại");
        };        
        if($yeuCauBaoHanh->DaXuLy == false)
        {
            $yeuCauBaoHanh->SoLuong = $data["SoLuong"];
            $yeuCauBaoHanh->NguyenNhanBaoHanh = $data["NguyenNhanBaoHanh"];
            $yeuCauBaoHanh->save();
            return ResponseJson::success(data:$yeuCauBaoHanh);
        }
        return ResponseJson::error("Yêu cầu bảo hành này đã được xử lý");
    }
    public static function delete($id)
    {
        $yeuCauBaoHanh = yeucaubaohanh::find($id);
        if(!isset($yeuCauBaoHanh)){
            return ResponseJson::error("Yêu cầu bảo hành này không tồn tại");
        };        
        if($yeuCauBaoHanh->DaXuLy == false)
        {
            $yeuCauBaoHanh->delete();
            return ResponseJson::success("Hủy yêu cầu bảo hành thành công");
        }
        return ResponseJson::error("Yêu cầu bảo hành này đã được xử lý, không thể xóa");
    }

}

