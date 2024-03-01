<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\yeucaubaohanh;

class GuaranteeController_1 extends Controller
{
    public function getListGuarentee(Request $request)
    {
        $dataBHJoin = DB::select('select yeucaubaohanh.*,hanghoa.*, donhang.*, khachhang.HoVaTen, 
        khachhang.SDT as SDTKH, khachhang.email as emailKH
         from yeucaubaohanh , donhang, hanghoa,khachhang 
        where yeucaubaohanh.MaDonhang =  donhang.MaDonhang and
        yeucaubaohanh.MaHang = hanghoa.MaHang and
        khachhang.MakH = donhang.MaDonhang ');
     
       return view("Guarantee.guarentee",["datayeucaubaohanhs"=>$dataBHJoin]);
    }

    public function getDeTailsGuarantee($idDH, $idHH)
    {
        $select = "SELECT yeucaubaohanh.*, hanghoa.*, donhang.*, khachhang.HoVaTen, 
            khachhang.SDT as SDTKH, khachhang.email as emailKH
            FROM yeucaubaohanh, donhang, hanghoa, khachhang
            WHERE  
                yeucaubaohanh.MaDonhang = $idDH AND yeucaubaohanh.MaHang = $idHH AND
                yeucaubaohanh.MaDonhang = donhang.MaDonhang AND
                yeucaubaohanh.MaHang = hanghoa.MaHang AND
                khachhang.MakH = donhang.MaDonhang";
    
        $dataBHJoin = DB::select($select);
    
        return view("Guarantee.detailguarente", ["datayeucaubaohanhs" => $dataBHJoin]);
    }
    
}
