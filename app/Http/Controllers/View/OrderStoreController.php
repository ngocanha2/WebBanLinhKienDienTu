<?php

namespace App\Http\Controllers\View;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Models\donhang;
use App\Services\MailService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderStoreController extends Controller
{


    //cửa mẫn
    public function getListOrder(Request $request)//Lấy all DonHang
    {
       $data = DB::select("select * from donhang");
       
       return view("products.orderstore",["donhangs"=>$data,"status"=>0]);
    }
    public function getListOrderCancel(Request $request)//lấy DonHang => Hủy
    {
        $data = DB::select("select * from donhang where TrangThai = N'Đã hủy'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>6]);
    }
    public function getListOrderWaitConfirmMail(Request $request)//lấy DonHang => Chờ xác thực
    {
        $data = DB::select("select * from donhang where TrangThai = N'Chờ xác thực'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>1]);
    }
    public function getListOrderWaitConfirm(Request $request)//lấy DonHang => Chờ xác nhận
    {
        $data = DB::select("select * from donhang where TrangThai = N'Chờ xác nhận'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>2]);
    }
    public function getListOrderHandle(Request $request)//lấy DonHang => Đang xử lý
    {
        $data = DB::select("select * from donhang where TrangThai = N'Đang xử lý'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>3]);
    }
    public function getListOrderDeliver(Request $request)//lấy DonHang => Đang giao
    {
        $data = DB::select("select * from donhang where TrangThai = N'Đang giao'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>4]);
    }
    public function getListOrderDelivered(Request $request)//lấy DonHang => Đã giao
    {
        $data = DB::select("select * from donhang where TrangThai = N'Đã giao'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>5]);
    }
    public function getListOrderRefuse(Request $request)//lấy DonHang => Bị từ chối
    {
        $data = DB::select("select * from donhang where TrangThai = N'Bị từ chối'");
        return view("products.orderstore",["donhangs"=>$data,"status"=>7]);
    }
    public function getDetailOrder($id)//Lấy chi tiết đơn hàng
    {
        $data = DB::select("select dh.*
        ,TrangThai
        from donhang dh
        where dh.MaDonhang = '$id'");
        $data1 = DB::select("select TenHang, HinhAnh, DonGia,  SoLuong
        from donhang dh, chitietdonhang ct, hanghoa hh
        where dh.MaDonhang = ct.MaDonhang and ct.MaHang = hh.MaHang
        and dh.MaDonhang = '$id'");
        $sl = DB::table("chitietdonhang")->where('MaDonhang',$id)->sum("SoLuong");
        $sosp = DB::table("chitietdonhang")->where('MaDonhang',$id)->count("MaHang");
        return view("products.detail-order-store",["donhangs"=>$data,"chitietdonhangs"=>$data1, "soluong"=>$sl,
    "sosp"=>$sosp]);
    }
    
    public function updateStatus($id)
    {
        $donHang = donhang::where('MaDonhang',$id)->first();        
        $trangThai = $donHang->TrangThai;
        $message = "Đơn hàng có mã '$donHang->MaDonhang' của bạn ";                 
        if($trangThai == "Chờ xác nhận")
        {
            $trangThai = "Đang xử lý";
            $message.="đã được xác nhận. Hiện đang trong quá trình đóng gói.";
        }
        else if($trangThai == "Đang xử lý")
        {
            $trangThai = "Đang giao";
            $message.="đóng gói hoàn tất và hiện đã giao cho đơn vị vận chuyển, rất sớm thôi đơn hàng sẽ đến tay của bạn.";
        }
        else if($trangThai == "Đang giao")
        {
            $trangThai = "Đã giao";
            $message.="đã giao hoàn tất. Cảm ơn bạn đã tin tưởng và đặt hàng ở chúng tôi. Nếu có thời gian, xin bạn hãy dành 1 chút xíu ra để đánh giá đơn hàng của mình nhé, điều này sẽ giúp chúng tôi cải thiện chất lượng rất nhiều";
        }         
        $donHang->TrangThai = $trangThai;
        $donHang->save();
        if( $donHang->TrangThai == "Đang xử lý")
            ProductService::updateQuantity($id,false);
        MailService::SendEmailUpdateStatusOrder($donHang,$message);
        return redirect("/detail-order-store/$id");
    }        
}