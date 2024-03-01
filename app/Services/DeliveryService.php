<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietgiaohang;
use App\Models\hanghoa;
use App\Models\phieugiaohang;
use App\Models\sodiachi;
use App\Repositories\Interface\PermissionRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\RouteRepositoryInterface;
use App\Repositories\Interface\ShortUrlRepositoryInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DeliveryService
{
    public static function gets($request)
    {
        $filter = $request->filter;
        $query = phieugiaohang::select("phieugiaohang.*","nhacungcap.MaNCC","nhacungcap.TenNCC")
                                ->join("phieudathang","phieudathang.SoPhieuDatHang","=","phieugiaohang.SoPhieuDatHang")
                                ->join("nhacungcap","nhacungcap.MaNCC","=","phieudathang.MaNCC");
        if($request->status!=0)
            $query=$query->where("TrangThai",DeliveryService::parseStatus($request->status));
        if(isset($filter) && $filter["MaNCC"]!="-1")
        {            
            $query=$query->where("phieudathang.MaNCC",$filter["MaNCC"]);
        }
        return ResponseJson::success(data:$query->paginate(10));        
    }
    public static function show($soPhieuGiao)
    {
        $phieuGiaoHang = phieugiaohang::find($soPhieuGiao);
        if(!isset($phieuGiaoHang))
            return ResponseJson::error("Số phiểu giao không tồn tại");
        $chiTiets = chitietgiaohang::join("hanghoa","hanghoa.MaHang","=","chitietgiaohang.MaHang")
                                ->where("SoPhieuGiaoHang",$soPhieuGiao)->get();
        $orderDetails = SupplierService::orderDetailsWithDeliveryStatus($phieuGiaoHang->SoPhieuDatHang,["Đã xác nhận"]);
        return ResponseJson::success(data:[
            "chitietgiaohang"=>$chiTiets,
            "chitietdathang"=>$orderDetails,
        ]);
    }
    public static function parseStatus($status)
    {
        switch ($status) {
            case 1:
                return "Chờ xác nhận";
            case 2:
                return "Đã xác nhận";
            case 3:
                return "Từ chối";
            default:
                return 0;
        }        
    }
    public static function confirmStatus($soPhieuGiao)
    {        
        $phieuGiaoHang = phieugiaohang::find($soPhieuGiao);
        if(!isset($phieuGiaoHang))
            return ResponseJson::error("Số phiếu giao hàng không tồn tại");
        $chiTietGiaoHangs = chitietgiaohang::where("SoPhieuGiaoHang",$soPhieuGiao)->get();
        foreach ($chiTietGiaoHangs as $chiTietGiaoHang) {
            hanghoa::where("MaHang",$chiTietGiaoHang->MaHang)
                    ->increment("SoLuongTon",$chiTietGiaoHang->SoLuong);
        }
        $phieuGiaoHang->TrangThai = "Đã xác nhận";
        $phieuGiaoHang->save();
        return ResponseJson::success("Xác nhận phiếu giao hàng thành công");
    }
    public static function cancel($soPhieuGiao,$lyDo)
    {
        $phieuGiaoHang = phieugiaohang::find($soPhieuGiao);   
        if(!isset($phieuGiaoHang))
            return ResponseJson::error("Số phiếu giao hàng không tồn tại");
        $phieuGiaoHang->GhiChu = $lyDo;     
        $phieuGiaoHang->TrangThai = "Từ chối";
        $phieuGiaoHang->save();
        return ResponseJson::success("Từ chối giao hàng thành công");
    }
}

