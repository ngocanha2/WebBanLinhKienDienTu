<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\giohang;
use App\Models\nhanvien;
use App\Models\Premium;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Str;

class AuthService
{
    public static function login($usertRepo,$fieldvalue,$password,$loginAdmin = false)
    {     
        // Auth::guard('user-api')->logout();
        Session::remove("admin");
        if($loginAdmin)
        {                                        
            $user = ["TenDangNhap" => $fieldvalue, 'password' => $password];                                    
            $token = auth('admin-api')->attempt($user);  
            if($token!=false);
            {
                $user = nhanvien::where("TenDangNhap",$fieldvalue)->first();
                Session::put("admin",$user);
                Auth::guard("admin-api")->login($user);
            }            

        }
        else
        {                
            $field = $usertRepo->getField($fieldvalue); 
            // return $field;       
            $user = [$field => $fieldvalue, 'password' => $password];
            $token = auth("user-api")->attempt($user);
            // return $token;
            if($token!=false);
            {
                $user = Auth::guard("user-api")->user();
                $carts = Session::pull(config('app.CART_NAME'));
                if(isset($carts)) 
                {      
                                                                   
                    foreach ($carts as $hangHoa) 
                    {
                        $query = giohang::where("MaKH",$user->MaKH)
                            ->where("MaHang",$hangHoa["MaHang"]);
                        $cartItem = $query->first();
                        if(isset($cartItem) && count($cartItem) > 0)
                        {
                            $soLuongTrongGio =  $hangHoa->SoLuongTon < ($hangHoa['SoLuongTrongGio'] + $cartItem->SoLuongTrongGio) ? $hangHoa->SoLuongTon : $hangHoa['SoLuongTrongGio'] + $cartItem->SoLuongTrongGio;
                            $query->update([
                                "SoLuongTrongGio"=>$soLuongTrongGio
                            ]);                            
                        }
                        else                        
                            giohang::create([
                                "MaKH"=>$user->MaKH,
                                "MaHang"=>$hangHoa["MaHang"],
                                "SoLuongTrongGio"=>$hangHoa['SoLuongTrongGio']
                            ]);
                    }                                                            
                }                 
            }                             
        }
        return $token;                 
    }
    public static function register($usertRepo,$full_name, $email, $password)
    {
                                                                                
        if($usertRepo->findBy("email",$email)->first())
            return ResponseJson::errors([
                "email"=> ["Email already exists!"],
            ],statusCode:422);        
        $token = strtoupper(Str::random(20));
        $username = "";
        $countUser = $usertRepo->all()->count();
        do
        {
            $username = "user0".strval(++$countUser);
        }while($usertRepo->findBy("TenDangNhap",$username)->first()!=null);       
        $user = [    
            "TenDangNhap"=>$username,
            "HoVaTen"=>$full_name,            
            "Email"=>$email,
            "password"=>$password,             
            "token"=>$token,                              
        ];        
        MailService::SendVerifyEmail($usertRepo->create($user));              
        return ResponseJson::success(msg:"Tạo tài khoản thành công. Vui lòng xác minh email của bạn để hoàn tất quá trình đăng ký");
    }
    public static function logout()
    {
        //Auth::logout();        
        return ResponseJson::success("Log out successfully");          
    }

}

