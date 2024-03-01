<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Services\CartService;
use App\Services\MailService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orderFaild()
    {
        return view("order.faild");
    }
    public function checkout()
    {
        return view("order.checkout");
    }
    public function orderSuccess()
    {
        return view("order.success");
    }
    public function paymentOnlineSuccess(string $keyId, Request $request)
    {
        $inputData = array();        
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, config("app.VNP_HASHSECRET"));                                       
        if ($secureHash == $vnp_SecureHash)         
        {                        
            $orderId = $inputData['vnp_TxnRef'];
            if($orderId == $keyId){
                $data = Session::pull($keyId);
                $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi 
                if($data["donHang"]["ThanhTien"] == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                {
                    if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00')
                    {
                        $data["donHang"]["TrangThai"] = "Đang xử lý";
                        $donHang = donhang::create($data["donHang"]);
                        $chiTietDonHangs = $data["chiTietDonHangs"];                           
                        foreach ($chiTietDonHangs as &$chiTietDonHang) {
                            $chiTietDonHang["MaDonhang"] = $donHang->MaDonhang;                                                                
                        }                                                   
                        chitietdonhang::insert($chiTietDonHangs);
                        CartService::deleteProductFromCartOnceOrder($chiTietDonHangs);
                        ProductService::updateQuantity($donHang->MaDonhang,false);
                        MailService::SendEmailOrderPaymentOnline($donHang,"Bạn đã đặt 1 đơn hàng và đã thanh toán thành công");
                        return redirect()->route("orderSuccess",["id"=>$donHang->MaDonhang,"token"=>$donHang->token]);
                    }
                }
            } 
        } 
        return redirect()->route("orderFaild");
    }
}
