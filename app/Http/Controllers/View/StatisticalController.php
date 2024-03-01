<?php

namespace App\Http\Controllers\View;

//có mấy cái Class Reqquest lận, dùng cái này: use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// nhứ usẻ cái này
// còn mà m muốn tạo controller, thì m cứ create 1 casll mới, r coprr mấy cái controler cũ đổ dô là đc
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class StatisticalController extends Controller
{
    // public function getView(Request $request)
    // {
    //     $viewName = 'products.statistical';
    //     // Load view và lấy nội dung
    //     $viewContent = View::make($viewName)->render();
    // }
    public function getList(Request $request)
    {
       $ngaybd = $request->input("txt_NgayBD");
       $ngaykt = $request->input("txt_NgayKT");
       $nam = $request->input("cbo_Nam");
       $data = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
       from donhang where 
       TrangThai = 'Đã giao' and NgayMua BETWEEN '$ngaybd' and '$ngaykt'");//Số hd, doanh thu
       $data1 = DB::select("select DISTINCT hh.MaHang, hh.TenHang, SUM(SoLuong) as TongSoLuong,AVG(MucDoHaiLong) as DanhGia
       from chitietdonhang ct, hanghoa hh, donhang dh
       where ct.MaHang = hh.MaHang and ct.MaDonhang = dh.MaDonhang and dh.NgayMua BETWEEN '$ngaybd' and '$ngaykt' and dh.TrangThai = 'Đã giao'
       GROUP by hh.MaHang, hh.TenHang");//SP, Tổng SL
       //SP bán chạy nhất
       $data2 = DB::select("select DISTINCT hh.MaHang, hh.TenHang, SUM(SoLuong) as TongSoLuong,AVG(MucDoHaiLong) as DanhGia
       from chitietdonhang ct, hanghoa hh, donhang dh
       where ct.MaHang = hh.MaHang and ct.MaDonhang = dh.MaDonhang and dh.NgayMua BETWEEN '$ngaybd' and '$ngaykt' and dh.TrangThai = 'Đã giao'
       GROUP by hh.MaHang, hh.TenHang
		ORDER by TongSoLuong DESC
        LIMIT 1");
        
       $sodon = $data[0]->SoDon;
       $tongTien = $data[0]->TongTien;
        //chart => Lấy số đơn, doanh thu từng tháng năm hiện tại
        if($nam == null)//if năm = null => lấy năm hiện tại
        {
            $nam = "YEAR(CURRENT_DATE())";
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 1 and Year(NgayMua) = $nam");
        $sodonNamT1 = $chart[0]->SoDon;
        $tongtienNamT1 = $chart[0]->TongTien;
        if($sodonNamT1 == 0 && $tongtienNamT1 == null)
        {
            $sodonNamT1 = 0;
            $tongtienNamT1 = 0;
        }

        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 2 and Year(NgayMua) = $nam");
        $sodonNamT2 = $chart[0]->SoDon;
        $tongtienNamT2 = $chart[0]->TongTien;
        if($sodonNamT2 == 0 && $tongtienNamT2 == null)
        {
            $sodonNamT2 = 0;
            $tongtienNamT2 = 0;
        }

        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 3 and Year(NgayMua) = $nam");
        $sodonNamT3 = $chart[0]->SoDon;
        $tongtienNamT3 = $chart[0]->TongTien;
        if($sodonNamT3 == 0 && $tongtienNamT3 == null)
        {
            $sodonNamT3 = 0;
            $tongtienNamT3 = 0;
        }

        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 4 and Year(NgayMua) = $nam");
        $sodonNamT4 = $chart[0]->SoDon;
        $tongtienNamT4 = $chart[0]->TongTien;
        if($sodonNamT4 == 0 && $tongtienNamT4 == null)
        {
            $sodonNamT4 = 0;
            $tongtienNamT4 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 5 and Year(NgayMua) = $nam");
        $sodonNamT5 = $chart[0]->SoDon;
        $tongtienNamT5 = $chart[0]->TongTien;
        if($sodonNamT5 == 0 && $tongtienNamT5 == null)
        {
            $sodonNamT5 = 0;
            $tongtienNamT5 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 6 and Year(NgayMua) = $nam");
        $sodonNamT6 = $chart[0]->SoDon;
        $tongtienNamT6 = $chart[0]->TongTien;
        if($sodonNamT6 == 0 && $tongtienNamT6 == null)
        {
            $sodonNamT6 = 0;
            $tongtienNamT6 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 7 and Year(NgayMua) = $nam");
        $sodonNamT7 = $chart[0]->SoDon;
        $tongtienNamT7 = $chart[0]->TongTien;
        if($sodonNamT7 == 0 && $tongtienNamT7 == null)
        {
            $sodonNamT7 = 0;
            $tongtienNamT7 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 8 and Year(NgayMua) = $nam");
        $sodonNamT8 = $chart[0]->SoDon;
        $tongtienNamT8 = $chart[0]->TongTien;
        if($sodonNamT8 == 0 && $tongtienNamT8 == null)
        {
            $sodonNamT8 = 0;
            $tongtienNamT8 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 9 and Year(NgayMua) = $nam");
        $sodonNamT9 = $chart[0]->SoDon;
        $tongtienNamT9 = $chart[0]->TongTien;
        if($sodonNamT9 == 0 && $tongtienNamT9 == null)
        {
            $sodonNamT9 = 0;
            $tongtienNamT9 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 10 and Year(NgayMua) = $nam");
        $sodonNamT10 = $chart[0]->SoDon;
        $tongtienNamT10 = $chart[0]->TongTien;
        if($sodonNamT10 == 0 && $tongtienNamT10 == null)
        {
            $sodonNamT10 = 0;
            $tongtienNamT10 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 11 and Year(NgayMua) = $nam");
        $sodonNamT11 = $chart[0]->SoDon;
        $tongtienNamT11 = $chart[0]->TongTien;
        if($sodonNamT11 == 0 && $tongtienNamT11 == null)
        {
            $sodonNamT11 = 0;
            $tongtienNamT11 = 0;
        }
        $chart = DB::select("select COUNT(MaDonhang) as SoDon, SUM(ThanhTien) as TongTien
        from donhang where 
        TrangThai = 'Đã giao' and Month(NgayMua) = 12 and Year(NgayMua) = $nam");
        $sodonNamT12 = $chart[0]->SoDon;
        $tongtienNamT12 = $chart[0]->TongTien;
        if($sodonNamT12 == 0 && $tongtienNamT12 == null)
        {
            $sodonNamT12 = 0;
            $tongtienNamT12 = 0;
        }

       return view("products.statistical-search",["sodonhang"=>$sodon, "tongtien"=>$tongTien,
        "dssanpham"=>$data1, "spchaynhat"=>$data2,
        "nam"=>$nam,
        "sodonnamt1"=>$sodonNamT1, "tongtiennamt1"=>$tongtienNamT1,
        "sodonnamt2"=>$sodonNamT2, "tongtiennamt2"=>$tongtienNamT2,
        "sodonnamt3"=>$sodonNamT3, "tongtiennamt3"=>$tongtienNamT3,
        "sodonnamt4"=>$sodonNamT4, "tongtiennamt4"=>$tongtienNamT4,
        "sodonnamt5"=>$sodonNamT5, "tongtiennamt5"=>$tongtienNamT5,
        "sodonnamt6"=>$sodonNamT6, "tongtiennamt6"=>$tongtienNamT6,
        "sodonnamt7"=>$sodonNamT7, "tongtiennamt7"=>$tongtienNamT7,
        "sodonnamt8"=>$sodonNamT8, "tongtiennamt8"=>$tongtienNamT8,
        "sodonnamt9"=>$sodonNamT9, "tongtiennamt9"=>$tongtienNamT9,
        "sodonnamt10"=>$sodonNamT10, "tongtiennamt10"=>$tongtienNamT10,
        "sodonnamt11"=>$sodonNamT11, "tongtiennamt11"=>$tongtienNamT11,
        "sodonnamt12"=>$sodonNamT12, "tongtiennamt12"=>$tongtienNamT12
    ]);
    }
    
}