<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\yeucaubaohanh;
use App\Models\hoadonbaohanhsuachua;

class GuaranteeController extends Controller
{
    public function getListGuarentee(Request $request)
    {
        
        $dataBHJoin = DB::select('
        SELECT yc.*,hh.*, dh.*, kh.HoVaTen, 
        kh.SDT as SDTKH, kh.Email as emailKH from yeucaubaohanh yc join donhang dh on yc.MaDonHang = dh.MaDonhang
        								join khachhang kh on dh.MaKH = kh.MaKH
                                        join hanghoa hh on yc.MaHang = hh.MaHang');
    //  dd($dataBHJoin);
       return view("Guarantee.guarentee",["datayeucaubaohanhs"=>$dataBHJoin]);
    }

    public function getDeTailsGuarantee($id)
    {
        $select = "SELECT yc.*, hh.*, dh.*, kh.HoVaTen, 
            kh.SDT as SDTKH, kh.email as emailKH from yeucaubaohanh yc join donhang dh on yc.MaDonHang = dh.MaDonhang
                                            join khachhang kh on dh.MaKH = kh.MaKH
                                            join hanghoa hh on yc.MaHang = hh.MaHang 
                                            where yc.id = $id";
    
        $dataBHJoin = DB::select($select);
    
        return view("Guarantee.detailguarente", ["datayeucaubaohanhs" => $dataBHJoin]);
    }

    public function updateStatus($idDH, $idHH, $tt)
    {
       
        $yeucaubaohanh = yeucaubaohanh::where('MaHang', $idHH)
        ->where('MaDonhang', $idDH)
        ->first();

        if (isset($yeucaubaohanh)) {
            yeucaubaohanh::where('MaHang', $idHH)
                        ->where('MaDonhang', $idDH)
                        ->update([
                            "DaXuLy"=>$tt
                        ]);
            return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy phiếu yêu cầu bảo hành'], 404);
        }
    }

    public function neworderhandelguarantee($id){
        $select = 
            "SELECT yc.*,hh.*, dh.*, kh.HoVaTen, 
            kh.SDT as SDTKH, kh.Email as emailKH from yeucaubaohanh yc join donhang dh on yc.MaDonHang = dh.MaDonhang
                                            join khachhang kh on dh.MaKH = kh.MaKH
                                            join hanghoa hh on yc.MaHang = hh.MaHang 
                                            where yc.id = $id";

        $data = DB::select($select);
        // dd($data);
        return view("Guarantee.orderhandelguarentee", ["dataYCBHs" => $data]);
    }

    public function themHoaDon(Request $request)
    {
        
        $hoadondata = $request->hoadondata;
        

        $yeuCauBaoHanhId = $hoadondata["YeuCauBaoHanhId"] ;
        $soLuongThayMoi = $hoadondata["SoLuongThayMoi"] ?? 0;
        $soLuongSuaChua = $hoadondata["SoLuongSuaChua"] ;
        $thanhTien = $hoadondata["ThanhTien"] ;
        $moTa = $hoadondata["MoTa"]?? "Không";


      hoadonbaohanhsuachua::create([
        'YeuCauBaoHanhId'=>$yeuCauBaoHanhId,
        'NgayTao'=> now(),   
        'SoLuongThayMoi'=> $soLuongThayMoi,
        'SoLuongSuaChua'=> $soLuongSuaChua,        
        'ThanhTien'=> $thanhTien,
        'MoTa'=>$moTa  
       ]);
        return response()->json(['success' => true, 'message' => 'Hóa đơn đã được thêm thành công']);
    }

    

    public function updateNexStatus($id,$tt)
    {
        $yeucaubaohanh = yeucaubaohanh::where('id', $id)
        ->first();

        if (isset($yeucaubaohanh)) {
            yeucaubaohanh::where('id', $id)
                        ->update([
                            "DaXuLy"=>$tt
                        ]);
            return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy phiếu yêu cầu bảo hành'], 404);
        }
    }

    public function xemChiTietHoaDonXuLy($id){

        $select = "SELECT hoadonbaohanhsuachua.*, yeucaubaohanh.*, hanghoa.TenHang, hanghoa.HinhAnh, khachhang.HoVaTen, 
        khachhang.SDT as SDTKH, khachhang.email as emailKH
        FROM yeucaubaohanh, donhang, hanghoa, khachhang,hoadonbaohanhsuachua
        WHERE  
            hoadonbaohanhsuachua.YeuCauBaoHanhId=$id AND
            yeucaubaohanh.id = hoadonbaohanhsuachua.YeuCauBaoHanhId AND
            yeucaubaohanh.MaHang = hanghoa.MaHang";

        $data = DB::select($select);
        return view("Guarantee.detailorderhandel",["dataHDs" => $data]);
    }
}
