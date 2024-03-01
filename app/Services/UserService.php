<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\User;
use App\Repositories\Interface\UserRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function getPaginated(UserRepositoryInterface $userRepo, ?int $perpage)
    {
        $data = User::paginate(10);
        return ResponseJson::success(data:$data);
    }
    public static function update($userRepo,$data,$user)
    {
        // return ResponseJson::status(data:$data,statusCode:401);
        if(!isset($data["TenDangNhap"])||trim($data["TenDangNhap"])=="")
            return ResponseJson::status(0,"Tên đăng nhập",statusCode:422);
        if(!isset($data["Email"])||trim($data["Email"])=="")
            return ResponseJson::status(-1,"Email không được để trống",statusCode:422);
        if(!isset($data["HoVaTen"])||trim($data["HoVaTen"])=="")
            return ResponseJson::status(-3,"Họ và tên không được để trống",statusCode:422);
        $userFind = $userRepo->findBy("TenDangNhap",$data["TenDangNhap"])->first();
        if(isset($userFind) && $userFind->MaKH != $user->MaKH){
            return ResponseJson::status(0,"Tên đăng nhập đã tồn tại",statusCode:422);
        }
        $userFind = $userRepo->findBy("Email",$data["Email"])->first();
        if(isset($userFind))
        {
            if($userFind->MaKH != $user->MaKH)
                return ResponseJson::status(-1,"Email mới đã tồn tại",statusCode:422);            
        }            
        if($data["Email"] != $user->Email)
        {
            $data["DaXacMinh"]=false;
            $user->email = $data["Email"];
            MailService::SendVerifyEmail($user); 
        }
        if(isset($data["SDT"]))
        {
            $userFind = $userRepo->findBy("SDT",$data["SDT"])->first();
            if(isset($userFind) && $userFind->MaKH != $user->MaKH)
                return ResponseJson::status(-2,"Số điện thoại đã tồn tại",statusCode:422);
        }
        if($userRepo->update($user->MaKH,$data) == false)
            return ResponseJson::failed("Cập nhật thất bại");
        return ResponseJson::success("Cập nhật thành công");
    } 
    public static function updatePassword($userRepo,$data,$user)
    {
        if($userRepo->checkPassword($user->MaKH,$data["old_password"]))            
        {            
            if($userRepo->update($user->MaKH,["password"=>$data["new_password"]])==false)
                return ResponseJson::failed("Update failed");
            return ResponseJson::success("Update successfully");
        }
        return ResponseJson::failed("Incorrect password");
    }
}

