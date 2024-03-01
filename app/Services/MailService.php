<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Jobs\AutomaticMassEmailJob;
use App\Jobs\SendVerificaEmailJob;
use App\Jobs\SendVerifyEmailJob;
use App\Models\chitietdonhang;
use App\Models\donhang;
use App\Models\Khachhang;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MailService
{    
    public static function SendVerifyEmail($user)
    {               
        SendVerifyEmailJob::dispatch($user);       
        return true;
    }

    public static function SendVerifyEmailResponseJson($user)
    {               
        MailService::SendVerifyEmail($user);       
        return ResponseJson::success("Email xác minh đã được gửi lại, vui lòng kiểm tra email của bạn");
    }

    //class MailService
    public static function verificaEmail($userRepo,$id, string $token)
    {
        $user = $userRepo->findBy("MaKH",$id)->first();        
        if($user->token == $token)
        {
            $user->DaXacMinh = true;
            $user->save();
            return ResponseJson::success("Xác minh email thành công");
        }               
        return ResponseJson::failed("Xác minh email thất bại"); 
    }

    public static function SendEmailVerifyOrder($email,$donHang, $chiTietDonHangs)
    {
        AutomaticMassEmailJob::dispatch([
            "email"=> $email,
            "full_name"=> $donHang["TenNguoiNhan"],
        ],isset($donHang->MaKH) ? "Bạn đã đặt một đơn hàng":"Xác thực email để hoàn tất quá trình đặt hàng","emails.verify_order",[
            "DonHang"=>$donHang,
            "ChiTietDonHangs"=> $chiTietDonHangs
        ]);
    }

    public static function SendEmailUpdateStatusOrder($donHang,$message)
    {        
        $khachHang = Khachhang::find($donHang["MaKH"]);
        if(!isset($donHang["Email"]) && !isset($khachHang))
            return false; 
        $email = trim($donHang["Email"]);
        if(isset($khachHang->Email))
            $email = $khachHang->Email;
        AutomaticMassEmailJob::dispatch([
            "email"=> $email,
            "full_name"=> $donHang["TenNguoiNhan"],
        ],"Thông báo tình trạng đơn hàng của bạn","emails.update_satus_order",[
            "DonHang"=>$donHang,    
            'message'=>$message        
        ]);
    }
    public static function SendEmailOrderPaymentOnline($donHang,$message)
    {        
        if(!isset($donHang["Email"]))
            return false;        
        AutomaticMassEmailJob::dispatch([
            "email"=> $donHang["Email"],
            "full_name"=> $donHang["TenNguoiNhan"],
        ],"Cảm ơn bạn đã đặt hàng và thanh toán đơn hàng thành công","emails.order_payment_online",[
            "DonHang"=>$donHang,    
            'message'=>$message        
        ]);
    }

    public static function SendEmailRefuseOrder($donHang)
    {        
        if(!isset($donHang["Email"]))
            return false;        
        AutomaticMassEmailJob::dispatch([
            "email"=> $donHang["Email"],
            "full_name"=> $donHang["TenNguoiNhan"],
        ],"Đơn hàng của bạn đã bị từ chối","emails.refuse_order",[
            "DonHang"=>$donHang,                        
        ]);
    }

    public static function verifyOrder($maDonHang, $token)
    {
        $donHang = donhang::find($maDonHang);
        if(isset($donHang))
        {
            if($donHang->TrangThai == "Chờ xác thực")
            {
                if($donHang->token == $token)
                {
                    $donHang->TrangThai = "Chờ xác nhận";
                    $donHang->save();
                    return 1;
                }
                return 0;
            }
            return -1;
        }
        return -2;
    }
    public static function SendMassMail($title,$content,$sendAll,$emailStr)
    {
        if($sendAll == true)
        {
            $users = User::all();
            foreach ($users as $user) {
                if(isset($user->Email))
                    AutomaticMassEmailJob::dispatch([
                        "email"=> $user->Email,
                        "full_name"=> $user->HoVaTen,
                    ],$title,"emails.mass_mail",$content);                    
            }
        }
        else
        {
            $emails = explode(" ",$emailStr);
            foreach ($emails as $email) {
                if(filter_var($email, FILTER_VALIDATE_EMAIL))
                    AutomaticMassEmailJob::dispatch([
                        "email"=>$email,
                        "full_name"=>"---",
                    ],$title,"emails.mass_mail",$content);
            }
        }
        return ResponseJson::success("Gửi mail thàng công");
    }
    public static function sendHappyBirthdayEmail()
    {    
        $users = User::all();
        foreach ($users as $user) { 
            if(isset($user->Email) && $user->isBirthday())                              
            AutomaticMassEmailJob::dispatch([
                "email"=> $user->Email,
                "full_name"=> $user->HoVaTen,
            ],"Chúc mừng sinh nhật","emails.happy_birthday",$user);                    
        }
    }    
}


