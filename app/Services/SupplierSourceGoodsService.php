<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietgiaohang;
use App\Models\hanghoa;
use App\Models\nguonhang;
use App\Models\phieugiaohang;
use App\Models\sodiachi;
use App\Repositories\Interface\PermissionRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\RouteRepositoryInterface;
use App\Repositories\Interface\ShortUrlRepositoryInterface;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SupplierSourceGoodsService
{
    public static function gets($maNCC = null)
    {        
        $query = nguonhang::select("nguonhang.*","hanghoa.TenHang")
                                ->join("hanghoa","hanghoa.MaHang","=","nguonhang.MaHang");
        $hangHoas = null;
        if(isset($maNCC) && $maNCC!="-1")
        {            
            $query=$query->where("nguonhang.MaNCC",$maNCC);
            $hangHoas = hanghoa::whereNotIn('MaHang', function($query) use ($maNCC) {
                $query->select('MaHang')->from('nguonhang')->where('MaNCC', $maNCC);
            })->get();
        }        
        return ResponseJson::success(data:[
            "nguonHangs"=>$query->paginate(5),
            "hangHoas"=>$hangHoas
        ]);        
    }    
    public static function store($maNCC,Request $request)
    {
        $hangHoa = hanghoa::find($request->MaHang);
        if(!isset($hangHoa))
            return ResponseJson::error("Mã hàng hóa không tồn tại");
        $nguonHang = nguonhang::where("MaNCC",$maNCC)
                                ->where("MaHang",$request->MaHang)
                                ->first();
        if(isset($nguonHang))
            return ResponseJson::error("Nguồn hàng này đã tồn tại");
        $nguonHang = nguonhang::create([
            'MaHang'=>$request->MaHang,
            'MaNCC'=>$maNCC,   
            'GiaNhap'=>$request->GiaNhap
        ]);
        return ResponseJson::success(data:$nguonHang);
    }
    public static function updatePrice($maNCC,$maHang, $giaNhap)
    {        
        $query = nguonhang::where("MaNCC",$maNCC)
                ->where("MaHang",$maHang);
        $nguonHang = $query->first();
        if(!isset($nguonHang))
            return ResponseJson::error("Nguồn hàng này không tồn tại");
        $query->update([
            "GiaNhap"=>$giaNhap
        ]);
        return ResponseJson::success("Cập nhật giá nhập thành công");
    }  
    public static function delete($maNCC,$maHang)
    {        
        $query = nguonhang::where("MaNCC",$maNCC)
                ->where("MaHang",$maHang);
        $nguonHang = $query->first();
        if(!isset($nguonHang))
            return ResponseJson::error("Nguồn hàng này không tồn tại");
        $query->delete();
        return ResponseJson::success("Xóa nguồn hàng thành công");
    }  
}

