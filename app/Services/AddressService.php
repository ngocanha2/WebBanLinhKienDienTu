<?php
namespace App\Services;

use App\Helpers\ResponseJson;
use App\Models\hanghoa;
use App\Models\sodiachi;
use App\Repositories\Interface\PermissionRepositoryInterface;
use App\Repositories\Interface\RoleRepositoryInterface;
use App\Repositories\Interface\RouteRepositoryInterface;
use App\Repositories\Interface\ShortUrlRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AddressService
{    
    public static function getMyAddress()
    {
        
        $user = auth()->user();        
        return sodiachi::where("MaKH",$user->MaKH)->get();        
    }
    public static function create($data)
    {                        
        $user = auth()->user(); 
        $data["MacDinh"] = boolval($data["MacDinh"] ?? false);       
        $addressDefault = sodiachi::where("MaKH",$user->MaKH)
                                    ->where("MacDinh",true)
                                    ->first();
        if(isset($addressDefault))        
        {
            if($data["MacDinh"])
            {
                $addressDefault->MacDinh = false;
                $addressDefault->save();
            } 
        }                                  
        else
            $data["MacDinh"] =true;        
        return sodiachi::create([
            "MaKH"=>$user["MaKH"],
            "DiaChiCuThe"=>$data["DiaChiCuThe"],
            "DiaChi"=>$data["DiaChi"],
            "TenNguoiNhan"=>$data["TenNguoiNhan"],
            "SDT"=>$data["SDT"],
            "MacDinh"=>  $data["MacDinh"],                        
        ]);
    }
    public static function update(int $maDiaChi,$data)
    {
        $user = auth()->user();
        $address = sodiachi::find($maDiaChi);
        if(!isset($address))        
            return 0;
        $data["MacDinh"] = boolval($data["MacDinh"] ?? false);
        if($address->MaKH == $user->MaKH)
        {        
            $diaChi = sodiachi::where("MaKH",$user->MaKH)
                            ->where("MaDiaChi","<>",$maDiaChi)
                            ->first();
            if(!isset($diaChi))
                $data["MacDinh"] = true;
            else if($address->MacDinh == true && $data["MacDinh"] == false)
            {
                $diaChi->MacDinh  = true;
                $diaChi->save();
            }
            else if($address->MacDinh == false && $data["MacDinh"] == true)
                AddressService::setAddressUnDefault($user->MaKH);
            $address->DiaChiCuThe = $data["DiaChiCuThe"];
            $address->DiaChi = $data["DiaChi"];
            $address->TenNguoiNhan = $data["TenNguoiNhan"];
            $address->SDT = $data["SDT"];
            $address->MacDinh = $data["MacDinh"];
            $address->save();
            return $address;
        } 
        return -1;   
    }
    public static function updateDefault(int $maDiaChi)
    {
        $user = auth()->user();        
        $address = sodiachi::find($maDiaChi);
        if(isset($address))
        {
            if($address->MaKH == $user->MaKH)
            {
                AddressService::setAddressUnDefault($user->MaKH);           
                $address->MacDinh = true;
                $address->save();
                return $address;
            } 
        }  
        return false;             
    }
    public static function setAddressUnDefault(int $maKH)
    {                
        sodiachi::where("MaKH",$maKH)
                ->where("MacDinh",true)
                ->update([
                    "MacDinh"=>false
                ]);           
    }
    public static function delete(string $maDiaChi)
    {
        $user = auth()->user();
        $address = sodiachi::where("MaDiaChi",$maDiaChi)
                            ->where("MaKH",$user->MaKH)
                            ->first();
        if($address->MacDinh)
        {
            $addressUpdateDefault = sodiachi::where("MaKH",$user->MaKH)
                                    ->first();
            if(isset($addressUpdateDefault))
            {
                
                $addressUpdateDefault->MacDinh = true;
                $addressUpdateDefault->save();
            }
        }
        if(isset($address))
            return $address->delete();
        return false;       
    }
}

