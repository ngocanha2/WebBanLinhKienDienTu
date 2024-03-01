<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietdonhang;
use App\Models\hanghoa;
use App\Repositories\Interface\PermissionRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\RouteRepositoryInterface;
use App\Repositories\Interface\ShortUrlRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ProductService
{    
    public static function getWithSaleIn(array $carts, array $maHangs)
    {
        $data = hanghoa::select("MaHang",
                "TenHang",
                "GiaBan",
                "SoLuongTon",
                "ThoiGianBaoHanh",
                "HinhAnh",
                "MaKhuyenMai",
                "MoTa",
                "khuyenmai.TyLeGiamGia",
                DB::raw('(GiaBan * (100 - IFNULL(khuyenmai.TyLeGiamGia, 0)) / 100) as GiaKhuyenMai'))
                ->leftJoin('khuyenmai',function($join){
                    $join->on('hanghoa.MaKhuyenMai','=','khuyenmai.MaKM')
                            ->where('khuyenmai.NgayBatDau', '<=', DB::raw('CURRENT_DATE'))
                            ->where('khuyenmai.NgayKetThuc', '>=', DB::raw('CURRENT_DATE'));
                })
                ->whereIn('MaHang', $maHangs)->get();
        $data = $data->map(function ($item) use ($carts) {
            $cartItem = collect($carts)->firstWhere('MaHang', $item->MaHang);        
        if ($cartItem)
            $item->SoLuongTrongGio = $cartItem['SoLuongTrongGio'];            
        return $item;
        });
        return $data;
    }
    public static function updateQuantity($id,$add = true){
        $chiTietDonHangs = chitietdonhang::where("MaDonHang",$id)->get();
        $value = $add ? 1 : -1;
        foreach ($chiTietDonHangs as $chiTietDonHang) {
            hanghoa::where("MaHang",$chiTietDonHang->MaHang)
                    ->increment("SoLuongTon",$value*$chiTietDonHang->SoLuong);
        }
    }
}

