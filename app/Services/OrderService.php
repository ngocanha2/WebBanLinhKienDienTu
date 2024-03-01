<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietdathang;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\giohang;
use App\Models\hanghoa;
use App\Models\sodiachi;
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

class OrderService
{    
    public static function buildOrder(array $maHangs)
    {
        if(count($maHangs) == 0)
            return ResponseJson::error("Phải có ít nhất 1 phần tử để đặt hàng");
        Session::put(config('app.DATA_ORDER'),$maHangs);
        return ResponseJson::success(data:$maHangs);                 
    }

    public static function checkout()
    {
        if(Session::has(config('app.DATA_ORDER')))
        {
            $user = Auth::guard("user-api")->user();
            if(isset($user))
                $carts = giohang::where("MaKH",$user->MaKH)->get()->toArray();
            else        
                $carts = Session::get(config('app.CART_NAME')); 
            $maHangs = Session::get(config('app.DATA_ORDER'));
            $data = ProductService::getWithSaleIn($carts,$maHangs);
            return ResponseJson::success(data:$data);
        } 
        return ResponseJson::error("Không tìm thấy dữ liệu");                            
    }
    public static function create(Request $request)
    {
        if(Session::has(config('app.DATA_ORDER')))
        {
            $carts = Session::get(config('app.CART_NAME')); 
            $maHangs = Session::get(config('app.DATA_ORDER'));
            $data = ProductService::getWithSaleIn($carts,$maHangs);
            return ResponseJson::success(data:$data);
        } 
        return ResponseJson::error("Không tìm thấy dữ liệu");                            
    }

    public static function submitOrder($diaChi = null)
    {        
        if(Session::has(config('app.DATA_ORDER')))
        {
            $user = Auth::guard("user-api")->user();
            if(isset($user))
                $carts = giohang::where("MaKH",$user->MaKH)->get()->toArray();
            else            
                $carts = Session::get(config('app.CART_NAME'));
            $maHangs = Session::get(config('app.DATA_ORDER'));
            $data = ProductService::getWithSaleIn($carts,$maHangs);
            $phuongThucVanChuyen = $diaChi["VanChuyen"];
            $phuongThucThanhToan = $diaChi["ThanhToan"];
            if(isset($diaChi["MaDiaChi"]))
            {
                $diaChi = sodiachi::find($diaChi["MaDiaChi"]);      
                $trangThai = "Chờ xác nhận";                
            }          
            else
            {
                $trangThai = "Chờ xác thực";
                $token = strtoupper(Str::random(20));
            }            
            $donHang = [
                'NgayMua'=> Carbon::now(),                
                'TenNguoiNhan'=> $diaChi["TenNguoiNhan"],
                'SDT'=> $diaChi["SDT"],                
                'GhiChu'=> $diaChi["GhiChu"],
                'DiaChiGiaoHang'=> $diaChi["DiaChi"],
                'DiaChiCuThe'=> $diaChi["DiaChiCuThe"],
                'TrangThai'=> $trangThai,    
                "ThanhTien"=>0, 
                "PhuongThucVanChuyen"=>$phuongThucVanChuyen,
                "PhuongThucThanhToan"=>$phuongThucThanhToan,                   
            ];
            $msg = "Đặt hàng thành công";
            if(($user = auth()->user()))            
            {
                $donHang["MaKH"] = $user->MaKH;                            
                $email = $user->Email;                            
            }
            else
            {
                $donHang["token"] = $token; 
                $email = $diaChi["Email"]; 
                $msg .=". Vui lòng xác thực email của bạn để hoàn tất quá trình mua hàng";               
            } 
            $donHang["Email"] = $email;                                                 
            $chiTietDonHangs = [];
            $thanhTien = 0;
            foreach ($data as $sanPham) {
                array_push($chiTietDonHangs,[
                    // 'MaDonhang' =>$donHang->MaDonhang,
                    "MaHang"=> $sanPham["MaHang"],
                    "SoLuong"=> $sanPham["SoLuongTrongGio"],
                    "DonGia"=> $sanPham["GiaKhuyenMai"],  
                    "SoThangBaoHanh"=>$sanPham["ThoiGianBaoHanh"],                                    
                ]);
                $thanhTien = $thanhTien +($sanPham["SoLuongTrongGio"] * $sanPham["GiaKhuyenMai"]);
            }
            $donHang["ThanhTien"] = $thanhTien;               
            if($phuongThucThanhToan == "Thanh toán online")
            {                             
                $key = "id".time();
                session()->put($key,[
                    "donHang"=>$donHang,
                    "chiTietDonHangs"=>$chiTietDonHangs
                ]);
                $url = PaymentVNPAYService::handle($key,$thanhTien);
            }                 
            else
            {
                $donHang = donhang::create($donHang);
                foreach ($chiTietDonHangs as &$chiTiet) {
                    $chiTiet["MaDonhang"] = $donHang->MaDonhang;
                }
                chitietdonhang::insert($chiTietDonHangs);   
                CartService::deleteProductFromCartOnceOrder($chiTietDonHangs);
                $url = route("orderSuccess")."?id=".$donHang->MaDonhang;
                MailService::SendEmailVerifyOrder($email,$donHang,$chiTietDonHangs);
            }            
            return ResponseJson::success($msg,data:[
                "donhang"=>$donHang,
                "url"=>$url,
            ]);
        } 
        return ResponseJson::error("Đơn hàng đã hết hạn");      
    }
}

