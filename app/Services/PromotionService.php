<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\hanghoa;
use App\Models\khuyenmai;
use App\Repositories\Interface\UserRepositoryInterface;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PromotionService
{
   public static function all($status)
   {
        $today = Carbon::now();
        switch ($status) {           
            case 1:                
                return khuyenmai::where("NgayBatDau","<=",$today)
                                    ->where("NgayKetThuc",">=",$today)
                                    ->get();
            case 2:                
                return khuyenmai::where("NgayBatDau",">",$today)                                    
                                    ->get();
            case 3:                
                return khuyenmai::where("NgayKetThuc","<",$today)
                                    ->get();
            default:
                return khuyenmai::all();                
        }
   }
   public static function create($data)
   {
        $khuyenMai = khuyenmai::create($data);
        return $khuyenMai;    
   }
   public static function update($maKhuyenMai,$data)
   {
        $khuyenMai = khuyenmai::find($maKhuyenMai);
        if(!isset($khuyenMai))
            return false;                  
        $khuyenMai->TenKhuyenMai = trim($data["TenKhuyenMai"]);
        $khuyenMai->TyLeGiamGia = $data["TyLeGiamGia"];        
        $khuyenMai->NgayBatdau = $data["NgayBatDau"];
        $khuyenMai->NgayKetThuc = $data["NgayKetThuc"];        
        $khuyenMai->save();
        return $khuyenMai;    
   }
   public static function delete($maKhuyenMai)
   {        
        $khuyenMai = khuyenmai::find($maKhuyenMai);
        if(!isset($khuyenMai))
            return 0; 
        if(hanghoa::where("MaKhuyenMai",$maKhuyenMai)->count() > 0)
            return -1;
        return $khuyenMai->delete();          
   }
}

