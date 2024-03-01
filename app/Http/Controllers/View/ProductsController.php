<?php

namespace App\Http\Controllers\View;

//có mấy cái Class Reqquest lận, dùng cái này: use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\chitietdathang;
use App\Models\chitietdonhang;
use App\Models\donhang;
use Illuminate\Http\Request;
use Str;
// nhứ usẻ cái này
// còn mà m muốn tạo controller, thì m cứ create 1 casll mới, r coprr mấy cái controler cũ đổ dô là đc
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{


    //của ánh
    public function getListProduct(Request $request)
    {
       $data = DB::select("select hanghoa.*,khuyenmai.TyLeGiamGia, (hanghoa.GiaBan* ((100-ifNull(khuyenmai.TyLeGiamGia,0))/100)) as GiaKhuyenMai from hanghoa LEFT join khuyenmai on hanghoa.MaKhuyenMai = khuyenmai.MaKM
                            and khuyenmai.NgayBatDau <= CURRENT_DATE
                            and khuyenmai.NgayKetThuc >= CURRENT_DATE");
       $data2 = DB::select("select * from danhmuc");
       return view("home",["hanghoas"=>$data, "danhmucs"=>$data2
    ]);
    }
   
    public function getDetailsProductById($id)
    {
     
        // $data = DB::table('hanghoa')->where('MaHang', $id)->first();
        $data = DB::select("select hanghoa.*,khuyenmai.TyLeGiamGia, (hanghoa.GiaBan* ((100-ifNull(khuyenmai.TyLeGiamGia,0))/100)) as GiaKhuyenMai from hanghoa LEFT join khuyenmai on hanghoa.MaKhuyenMai = khuyenmai.MaKM
                            and khuyenmai.NgayBatDau <= CURRENT_DATE
                            and khuyenmai.NgayKetThuc >= CURRENT_DATE where MaHang = $id")[0];
        $dataimage = DB::table('hinhanh')->where('MaHang', $id)->get();
        $data1 = DB::select("select MucDoHaiLong, NoiDungDanhGia, AnDanh, HoVaTen
        from chitietdonhang ct, donhang dh, khachhang kh
        where MaHang = $id and ct.MaDonhang = dh.MaDonhang and kh.MaKH = dh.MaKH and MucDoHaiLong is not null");
        //Đánh giá tb
        $data2 = DB::select("select AVG(MucDoHaiLong) as MucDo from chitietdonhang ct, hanghoa h where ct.MaHang = h.MaHang and h.MaHang = $id");
        //dd($id);
        $dgTB = $data2[0]->MucDo;
        return view("products.ProductDetail",["hanghoas"=>$data, "hinhanhs"=>$dataimage, "danhgias"=>$data1,
        "danhgiatb"=>$dgTB
        ]);
    }    

    public function getDetailsProductByCatogery($id)
    {
        $data = DB::select("select hanghoa.*,khuyenmai.TyLeGiamGia, (hanghoa.GiaBan* ((100-ifNull(khuyenmai.TyLeGiamGia,0))/100)) as GiaKhuyenMai from hanghoa LEFT join khuyenmai on hanghoa.MaKhuyenMai = khuyenmai.MaKM
        and khuyenmai.NgayBatDau <= CURRENT_DATE
        and khuyenmai.NgayKetThuc >= CURRENT_DATE where MaDanhMuc = $id");//DB::table('hanghoa')->where('MaDanhMuc', $id)->get();
        $data2 = DB::select("select * from danhmuc");
        
        return view("home",["hanghoas"=>$data,"danhmucs"=>$data2, 
     ]);
    }    
    
    public function searchProduct(Request $request)
    {
        $tukhoa = $request->input('txt_search');
        if (Str::startsWith($tukhoa, '/')) {
            $tukhoa = substr($tukhoa, 1);
            $donHang = donhang::where("token",$tukhoa)->first();
            $chiTietDonHangs = null;
            if(isset($donHang))
            {                
                $chiTietDonHangs = chitietdonhang::select("chitietdonhang.*","hanghoa.TenHang","hanghoa.HinhAnh")->join("hanghoa","hanghoa.MaHang","=","chitietdonhang.MaHang")->where("MaDonHang",$donHang->MaDonhang)->get();                
            }
            return view("home",[
                "searchOrder"=>true,
                "donHang"=>$donHang,
                "chiTietDonHangs"=>$chiTietDonHangs,
            ]);
        }
        else
        {

        }
        $data = DB::select("select hanghoa.*,khuyenmai.TyLeGiamGia, (hanghoa.GiaBan* ((100-ifNull(khuyenmai.TyLeGiamGia,0))/100)) as GiaKhuyenMai from hanghoa LEFT join khuyenmai on hanghoa.MaKhuyenMai = khuyenmai.MaKM
        and khuyenmai.NgayBatDau <= CURRENT_DATE
        and khuyenmai.NgayKetThuc >= CURRENT_DATE where TenHang LIKE '%$tukhoa%'");//DB::table('hanghoa')->where('TenHang', 'LIKE', '%' . $tukhoa . '%')->get();        
        $data2 = DB::select("select * from danhmuc");
        return view("home",["searchOrder"=>false,"hanghoas"=>$data,"danhmucs"=>$data2]);
    }  
    // public function getComment(Request $request, $id)
    // {
    //     $data = DB::select("select MucDoHaiLong, NoiDungDanhGia, AnDanh from chitietdonhang
    //     where MaHang = $id and MucDoHaiLong is not null");
    //     return view("products.ProductDetail",["danhgias"=>$datas]);
    // }   

}