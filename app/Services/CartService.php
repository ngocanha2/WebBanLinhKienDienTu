<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\giohang;
use App\Models\hanghoa;
use App\Models\khuyenmai;
use App\Repositories\Interface\UserRepositoryInterface;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public static function getQuantity()
    {
        $user = Auth::guard("user-api")->user();
        if(isset($user))
            return ResponseJson::success(data:giohang::where("MaKH",$user->MaKH)->count());
        $carts = Session::get(config('app.CART_NAME'));
        $cartLength = isset($carts) ? count($carts) : 0;
        return ResponseJson::success(data:$cartLength);
    }
    public static function getCarts()
    {
        $user = Auth::guard("user-api")->user();
        if(isset($user))
            $carts = giohang::where("MaKH",$user->MaKH)->get()->toArray();
        else
        {
            $carts = Session::get(config('app.CART_NAME'));
            if(!isset($carts)) 
                return ResponseJson::success(data:[]);
        }        
        // if(!isset($carts) || count($carts)==0) {
        //     $carts = [
        //             [
        //                 "MaHang"=> 2,                        
        //                 "SoLuongTrongGio"=> 2
        //             ],
        //             [
        //                 "MaHang"=> 3,                       
        //                 "SoLuongTrongGio"=> 3
        //             ],
        //             [
        //                 "MaHang"=> 4,                        
        //                 "SoLuongTrongGio"=> 1,
        //             ]
        //         ];
        //     Session::put(config('app.CART_NAME'), $carts);
        // }                         
        $maHangs = collect($carts)->pluck('MaHang')->all();        
        $data = ProductService::getWithSaleIn($carts,$maHangs);
        return ResponseJson::success(data:$data);       
    }    
    public static function insert(int $maHang,int $soLuong)
    {
        $product = hanghoa::find($maHang);
        if(!isset($product))
            return ResponseJson::error("Hàng hóa không tồn tại");
        if($product->SoLuongTon < $soLuong)
            return ResponseJson::error("Tổng số lượng khi thêm vào giỏ vượt quá số lượng tồn");
        $user = Auth::guard("user-api")->user();
        if(isset($user))
        {
            $query = giohang::where("MaKH",$user->MaKH)
                            ->where("MaHang",$maHang);
            $cartItem = $query->first();
            if(isset($cartItem))
            {
                if($product->SoLuongTon < $cartItem->SoLuongTrongGio +$soLuong)
                    return ResponseJson::error("Tổng số lượng khi thêm vào giỏ vượt quá số lượng tồn");
                $query->update([
                    "SoLuongTrongGio"=>$cartItem->SoLuong + $soLuong                 
                ]);
            }
            else
                giohang::create([
                    "MaKH"=>$user->MaKH,
                    "MaHang"=>$maHang,
                    "SoLuongTrongGio"=>$soLuong
                ]);
        }
        else
        {
            $carts = Session::get(config('app.CART_NAME'));
            if(isset($carts)) 
            {                                                        
                foreach ($carts as &$hangHoa)                     
                if($hangHoa['MaHang'] == $maHang)
                {                
                    if($product->SoLuongTon < $hangHoa['SoLuongTrongGio'] +$soLuong)
                        return ResponseJson::error("Tổng số lượng khi thêm vào giỏ vượt quá số lượng tồn");
                    $hangHoa['SoLuongTrongGio'] += $soLuong;
                    Session::put(config('app.CART_NAME'), $carts);
                    return ResponseJson::success(data:$carts);                                                                      
                }  
            }
            else
                $carts = array();                          
            $cart = [
                'MaHang'=> $maHang,            
                'SoLuongTrongGio'=>$soLuong,                                       
            ];
            array_push($carts,$cart);                                                                                            
            Session::put(config('app.CART_NAME'), $carts);
        }                     
        return ResponseJson::success("Thêm sản phẩm vào giỏ hàng thành công");
    }
    public static function updateQuantity(int $maHang, int $soLuong)    
    {                            
        $hangHoa = hanghoa::find($maHang);
        if(!isset($hangHoa))
            return ResponseJson::error("Hàng hóa không tồn tại");
        if($hangHoa->SoLuongTon < $soLuong)
            return ResponseJson::failed("Số lượng tồn trong kho không đủ"); 
        $user = Auth::guard("user-api")->user();
        if(isset($user))
        {
            $query = giohang::where("MaKH",$user->MaKH)
                            ->where("MaHang",$maHang);   
            $cartItem = $query->first();
            if(!isset($cartItem))                                        
                return ResponseJson::failed("Mã hàng hóa này không tồn tại trong giỏ hàng");
            $query->update([
                "SoLuongTrongGio"=>$soLuong                 
            ]);
            return ResponseJson::success("Cập nhật số lượng thành công");
        }
        else
        {
            $carts = Session::get(config('app.CART_NAME'));
            if(isset($carts)) 
            {                                                        
                foreach ($carts as &$hangHoa)                     
                    if($hangHoa['MaHang'] == $maHang)
                    {
                        $hangHoa['SoLuongTrongGio'] = $soLuong;
                        Session::put(config('app.CART_NAME'), $carts);
                        return ResponseJson::success("Cập nhật số lượng thành công");
                    }  
            }
            return ResponseJson::failed("Mã hàng hóa này không tồn tại trong giỏ hàng");
        }        
    }
    public static function delete(int $maHang)
    {
        $user = Auth::guard("user-api")->user();
        if(isset($user))
        {
            $query = giohang::where("MaKH",$user->MaKH)
                            ->where("MaHang",$maHang);   
            $cartItem = $query->first();
            if(!isset($cartItem))                                        
                return ResponseJson::failed("Mã hàng hóa này không tồn tại trong giỏ hàng");
            $query->delete();
            return ResponseJson::success("Xóa sản phẩm khỏi giỏ hàng thành công");
        }
        else
        {
            $carts = Session::get(config('app.CART_NAME'));
            if(isset($carts)) 
            {            
                for ($i=0; $i < count($carts); $i++)                 
                    if($carts[$i]['MaHang'] == $maHang)
                    {
                        array_splice($carts, $i, 1);
                        Session::put(config('app.CART_NAME'), $carts);
                        return ResponseJson::success("Xóa sản phẩm khỏi giỏ hàng thành công");                                                                      
                    }  
            }
            return ResponseJson::failed("Mã hàng hóa này không tồn tại trong giỏ hàng");
        }        
    }
    public static function deleteAll()
    {
        $user = Auth::guard("user-api")->user();
        if(isset($user))
            giohang::where("MaKH",$user->MaKH)->delete();
        else        
            Session::remove(config('app.CART_NAME'));
        return ResponseJson::success("Xóa giỏ hàng thành công");
    }
    public static function deleteProductFromCartOnceOrder($chiTietDonHangs)
    {
        $maHangs = collect($chiTietDonHangs)->pluck('MaHang')->all(); 
        $user = Auth::guard("user-api")->user();
        if(isset($user))
            giohang::where("MaKH",$user->MaKH)
                    ->whereIn("MaHang",$maHangs)
                    ->delete();
        else
        {
            $carts = Session::get(config('app.CART_NAME'));
            $cartsProductId = collect($carts)->pluck('MaHang')->all(); 
            if(isset($carts))
            {
                $countCart = count($maHangs);
                while($countCart>0)
                {
                    if (($key = array_search($maHangs[$countCart-1],$cartsProductId)) !== false) {
                        array_splice($carts, $key, 1);
                    }
                    $countCart--;
                }
                              
                Session::put(config('app.CART_NAME'), $carts);
            }            
        }
    }
}

