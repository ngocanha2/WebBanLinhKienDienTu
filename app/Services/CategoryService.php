<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\chitietgiaohang;
use App\Models\danhmuc;
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

class CategoryService
{
    public static function all()
    {
        return ResponseJson::success(data:danhmuc::paginate(config("app.PER_PAGE",10)));
    }
    public static function store($data)
    {
        $danhMuc = danhmuc::create([
            "TenDanhMuc"=>$data["TenDanhMuc"]
        ]);
        return ResponseJson::success(data:$danhMuc);
    }
    public static function update($id, $data)
    {
        $danhMuc = danhmuc::find($id);
        if(!isset($danhMuc))
            return ResponseJson::error("Mã danh mục không tồn tại");
        $danhMuc->TenDanhMuc = $data["TenDanhMuc"];
        $danhMuc->save();
        return ResponseJson::success(data:$danhMuc);
    }
    public static function delete($id)
    {
        $danhMuc = danhmuc::find($id);
        if(!isset($danhMuc))
            return ResponseJson::error("Mã danh mục không tồn tại");
        $hangHoa = hanghoa::where("MaDanhMuc",$id)->first();
        if(isset($hangHoa))
            return ResponseJson::error("Danh mục hiện đang có hàng hóa, không thể xóa");
        $danhMuc->delete();
        return ResponseJson::success("Xóa danh mục thành công");
    }
}

