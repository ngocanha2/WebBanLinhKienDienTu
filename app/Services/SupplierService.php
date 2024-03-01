<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\hanghoa;
use App\Models\nguonhang;
use App\Models\nhaCungCap;
use App\Repositories\Interface\UserRepositoryInterface;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SupplierService
{
     public static function all($status)
     {
          if(isset($status) && $status == 0)
               return nhacungcap::all();
          return nhacungcap::paginate(config("app.PER_PAGE",10));
     }
     public static function create($data)
     {
          $nhaCungCap = nhacungcap::create($data);
          return $nhaCungCap;    
     }
     public static function update($maNhaCungCap,$data)
     {
          $nhaCungCap = nhacungcap::find($maNhaCungCap);
          if(!isset($nhaCungCap))
               return false;                  
          $nhaCungCap->TenNCC = trim($data["TenNCC"]);
          $nhaCungCap->DiaChi = $data["DiaChi"];        
          $nhaCungCap->SDT = $data["SDT"];             
          $nhaCungCap->save();
          return $nhaCungCap;    
     }
     public static function delete($maNhaCungCap)
     {        
          $nhaCungCap = nhacungcap::find($maNhaCungCap);
          if(!isset($nhaCungCap))
               return 0; 
          if(nguonhang::where("MaNCC",$maNhaCungCap)->count() > 0)
               return -1;
          return $nhaCungCap->delete();          
     }
     public static function orderDetailsWithDeliveryStatus($orderNumber,$status)
     {
          return DB::table('chitietdathang as ctdh')
          ->select(
              'ctdh.SoPhieuDatHang',
              'ctdh.MaHang',
              'ctdh.SoLuong',
              'ctdh.DonGia',
              'hh.TenHang',
              DB::raw('COALESCE(SUM(ctgh.SoLuong), 0) as SoLuongDaGiao')
          )
          ->leftJoin('phieugiaohang as pgh', function ($join) use($status){
              $join->on('ctdh.SoPhieuDatHang', '=', 'pgh.SoPhieuDatHang')
                  ->whereIn('pgh.TrangThai',$status);
          })                        
          ->leftJoin('chitietgiaohang as ctgh', function ($join) {
              $join->on('pgh.SoPhieuGiaoHang', '=', 'ctgh.SoPhieuGiaoHang')
                  ->on('ctdh.MaHang', '=', 'ctgh.MaHang');
          })
          ->join('hanghoa as hh', 'ctdh.MaHang', '=', 'hh.MaHang')
          ->where('ctdh.SoPhieuDatHang', $orderNumber)                        
          ->groupBy(['ctdh.SoPhieuDatHang', 'ctdh.MaHang', 'ctdh.SoLuong', 'ctdh.DonGia','hh.TenHang'])
          ->get();
     }
}

