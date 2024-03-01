<?php

namespace App\Http\Controllers\View;


use App\Http\Controllers\Controller;
use App\Models\hanghoa;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\alert;

class ProductStoreController extends Controller
{


  //của mẫn
    public function getList(Request $request)
    {
       $data = DB::select("select * from hanghoa where FlagXoa = 0");
       return view("products.productstore",["hanghoas"=>$data]);
    }
    public function insertProduct(Request $request)//Thêm sp
    {
      
      if ($request->hasFile('hinh_anh')) 
        {
          
          $file = $request->file('hinh_anh');
          $tenHinh = time().$file->getClientOriginalName();
          $file->move(public_path("images"),$tenHinh);
        }           


      $tenHang = $request->input("txt_TenHang");
      $giaBan = $request->input("txt_GiaBan");
      $slTon = $request->input("txt_SoLuongTon");
      $tg = $request->input("txt_TGBaoHanh");
      $danhmuc = $request->input("cbo_DanhMuc");
      $khuyenmai = $request->input("cbo_KhuyenMai");
      $mota = $request->input("txt_MoTa");
      //$hinhAnh = $request->input("hinh_anh");
      $insertHangHoa = DB::table("hanghoa")->insert([
        "TenHang"=> "$tenHang",
        "GiaBan"=> (double)$giaBan,
        "SoLuongTon"=> (int)$slTon,
        "ThoiGianBaoHanh"=> (int)$tg,
        "HinhAnh"=> "$tenHinh",
        "FlagXoa"=> 0,
        "MaDanhMuc"=> (int)$danhmuc,
        "MaKhuyenMai"=> (int)$khuyenmai,
        "MoTa"=>"$mota"
      ]); 
      return redirect("productstore");
      }    

      public function viewInsertProduct(Request $request)//load danh mục, khuyến mãi => thêm
      {
      
        $data_DanhMuc = DB::select("select * from danhmuc");
        $data_KhuyenMai = DB::select("select * from khuyenmai");
        
        return view("products.insertproductstore", ["danhmucs"=>$data_DanhMuc,
        "khuyenmais"=>$data_KhuyenMai]);
      }    
    
    public function deleteProduct($id)//update cờ xóa = 1 (Đã xóa)
    {
        $data = DB::update("update hanghoa set FlagXoa = 1 where MaHang = '$id'");
        return redirect("/productstore");
    }
    public function detailProduct($id)//Chi tiết sp
    {
      $data = DB::select("select * from hanghoa where MaHang = '$id'");
      $data1 = DB::select("select * from danhmuc, hanghoa where danhmuc.MaDanhMuc = hanghoa.MaDanhMuc and MaHang = '$id'");
      $data2 = DB::select("select * from khuyenmai, hanghoa where khuyenmai.MaKM = hanghoa.MaKhuyenMai and MaHang = '$id'");
      $data3 = DB::select("select * from danhmuc");
      $data4 = DB::select("select * from khuyenmai");
      return view('products.detail-product-store',['hanghoas'=>$data, "danhmucs"=>$data1, "khuyenmais"=>$data2,
    "danhmucall"=>$data3, "khuyenmaiall"=>$data4]);
      
    }    
    // public function getDetailUpdateProduct($id)
    // {
    //     $data = DB::select("select * from hanghoa where MaHang = '$id'");
    //     $data1 = DB::select("select * from danhmuc, hanghoa where danhmuc.MaDanhMuc = hanghoa.MaDanhMuc and MaHang = '$id'");
    //     $data2 = DB::select("select * from khuyenmai, hanghoa where khuyenmai.MaKM = hanghoa.MaKhuyenMai and MaHang = '$id'");
    //     return view('products.update-detail-product-store',['hanghoas'=>$data, "danhmucs"=>$data1, "khuyenmais"=>$data2]);
    // }
    public function updateProduct(Request $request, $id)// Update sản phẩm
    {
      $tenHang = $request->input("txt_Ten");
      $giaBan = $request->input("txt_GiaBan");
      $slTon = $request->input("txt_SLTon");
      $tg = $request->input("txt_TGBaoHanh");
      $danhmuc = $request->input("cbo_DanhMuc");
      $khuyenmai = $request->input("cbo_KhuyenMai");
      $mota = $request->input("txt_MoTa");
      $sql = "update hanghoa set TenHang = '$tenHang', GiaBan = $giaBan,
      SoLuongTon = $slTon, ThoiGianBaoHanh = $tg, MaDanhMuc = $danhmuc, 
      MaKhuyenMai = $khuyenmai, MoTa = '$mota'";
      if ($request->hasFile('hinh_anh')) 
      {
        
        $file = $request->file('hinh_anh');
        $tenHinh = time().$file->getClientOriginalName();
        $file->move(public_path("images"),$tenHinh);
        $sql.=", HinhAnh = '$tenHinh'";
      } 
      $sql.=" where MaHang = $id";
       
        $data1 = DB::select($sql);
        //DB::update("update hanghoa set TenHang = ? where MaHang = ?", [$tenHang, $id]);
        return redirect("/productstore");
    }
}