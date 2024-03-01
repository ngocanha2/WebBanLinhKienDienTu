<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietdathang;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\hanghoa;
use App\Models\sodiachi;
use App\Models\yeucaubaohanh;
use App\Repositories\Interface\PermissionRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\RouteRepositoryInterface;
use App\Repositories\Interface\ShortUrlRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;

class OrderPersonalService
{    
    public static function getDataOrderWithStatus(?int $status = 0)
    {
        $user = auth()->user();
        $query = donhang::where("MaKH",$user->MaKH);
        return ResponseJson::success(data:OrderPersonalService::getDataParseStatus($query,$status));                 
    }
    public static function show(int $id)
    {        
        $donHang = donhang::find($id);
        if(!isset($donHang))
            return ResponseJson::error("Mã đơn hàng không tồn tại");
        $user = auth()->user(); 
        if($donHang->MaKH != $user->MaKH)
            return ResponseJson::error("Bạn không có quyền truy cập đơn hàng này");       
        $chiTietDonHangs = chitietdonhang::select(
            "chitietdonhang.*",
            "hanghoa.TenHang",
            "hanghoa.HinhAnh",
            "yeucaubaohanh.id as idYeuCauBaoHanh",
            "yeucaubaohanh.NgayYeuCau as NgayYeuCauBaoHanh",
            "yeucaubaohanh.NguyenNhanBaoHanh",
            "yeucaubaohanh.DaXuLy as DaXuLyBaoHanh",
            "yeucaubaohanh.SoLuong as SoLuongBaoHanh",
        )
                                        ->leftJoin("yeucaubaohanh",function($join){
                                            $join->on("yeucaubaohanh.MaDonHang","=","chitietdonhang.MaDonHang")
                                            ->on("yeucaubaohanh.MaHang","=","chitietdonhang.MaHang")
                                            ->where("yeucaubaohanh.DaXuLy","=",0);
                                        })
                                        ->join("hanghoa","HangHoa.MaHang","=","chitietdonhang.MaHang")
                                        ->where("chitietdonhang.MaDonHang",$id)->get();
        return ResponseJson::success(data:[
            "donhang"=>$donHang,
            "chitietdonhangs"=>$chiTietDonHangs
        ]);          
    }
    public static function getDataParseStatus($query,$status)
    {                
        switch ($status) {
            case 1:
                $trangThai = "Chờ xác nhận";
                $query = $query->where("TrangThai",$trangThai);
                break;
            case 2:
                $trangThai = "Đang xử lý";
                $query = $query->where("TrangThai",$trangThai);
                break;
            case 3:
                $trangThai = "Đang giao";
                $query = $query->where("TrangThai",$trangThai);
                break;
            case 4:
                $trangThai = "Đã giao";
                $query = $query->where("TrangThai",$trangThai);
                break;  
            case 5:
                $trangThai = "Đã hủy";
                $query = $query->where("TrangThai",$trangThai);
                break;
            case 6:
                $trangThai = "Bị từ chối";
                $query = $query->where("TrangThai",$trangThai);
                break;                                       
        }   
        $data =  $query->paginate(5);  
        return $data;//["data"];
    }

    public static function cancelOrder($id,$data)
    {
        $donHang = donhang::find($id);
        if(!isset($donHang))
            return ResponseJson::error("Mã đơn hàng không tồn tại");
        if($donHang->TrangThai == "Chờ xác thực"||$donHang->TrangThai == "Chờ xác nhận"||$donHang->TrangThai == "Đang xử lý")
        {
            if(!isset($donHang->MaKH) && strtolower($donHang->Email) != strtolower($data["email"]))
                return ResponseJson::error("Địa chỉ email không chính xác");
            $user = Auth::guard("user-api")->user();
            if(isset($user)&& isset($donHang->MaKH) && $donHang->MaKH != $user->MaKH)
                return ResponseJson::error("Không có quyền truy cập",401);
            $trangThaiCu = $donHang->TrangThai;
            $donHang->TrangThai = "Đã hủy";
            $donHang->GhiChu = $data["ly_do"];
            $donHang->save();
            if($trangThaiCu == "Đang xử lý")
            {                
                ProductService::updateQuantity($id);
            }                
            return ResponseJson::success("Hủy bỏ đơn hàng thành công");
        }
        return ResponseJson::error("Trạng thái của đơn hàng không thể hủy bỏ được nữa");
    }

    
}

