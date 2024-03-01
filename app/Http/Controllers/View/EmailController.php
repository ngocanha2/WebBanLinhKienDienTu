<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Jobs\SendVerificaEmailJob;
use App\Models\Users;
use App\Services\MailService;
use Illuminate\Http\Request;

class EmailController extends Controller
{

    
    public function verifyEmail($id, string $token)
    {        
        return view("auth.verify_email",[
            "id"=>$id,
            "token"=>$token
        ]); 
    }
    
    // public function sendAllEmail()
    // {
    //     MailService::sendAllEmails();
    //     return redirect()->route("managerUsers",["sendEmail"=>true]);
    // }
    public function verifyOrder($maDonHang, string $token)
    {
        if(($status =  MailService::verifyOrder($maDonHang,$token)) > 0)
            return view("order.verify_order_success",[
                "token"=>$token
            ]);
        return view("order.verify_order_fail",[
            "error"=> $status == 0 ? "Mã xác thực không chính xác": ($status == -1 ? "Đơn hàng đã được xác thực trước đó" : "Đơn hàng không tồn tại")
        ]);
    }
}


