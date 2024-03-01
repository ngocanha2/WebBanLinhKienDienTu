<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Services\AddressService;
use Illuminate\Http\Request;

class AddressPersonalApiController extends Controller
{    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Call::TryCatchResponseJson(function(){
            return ResponseJson::success(data:AddressService::getMyAddress());                        
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
            if(($address =  AddressService::create($request->all())) != null)
                return ResponseJson::success(data:$address);
            return ResponseJson::failed("Thêm địa chỉ thất bại");                        
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $maDiaChi)
    {
        return Call::TryCatchResponseJson(function()use($maDiaChi,$request){
            $address =  AddressService::update($maDiaChi,$request->all());  
            if($address === 0)
                ResponseJson::failed("Không tìm thấy địa chỉ");            
            else if($address === -1)  
                return ResponseJson::failed("Bạn không có quyền cập nhật địa chỉ này");
            else if($address === -2)
                return ResponseJson::failed("Không thể xóa mặc định khi bạn chỉ còn 1 địa chỉ");
            return ResponseJson::success(data:$address);                        
        });
    }

    public function updateDefault(int $maDiaChi)
    {
        return Call::TryCatchResponseJson(function()use($maDiaChi){
            if(($address =  AddressService::updateDefault($maDiaChi)) != false)
                return ResponseJson::success(data:$address);
            return ResponseJson::failed("Không tìm thấy địa chỉ hoặc bạn không có quyền cập nhật địa chỉ này");                        
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $maDiaChi)
    {
        return Call::TryCatchResponseJson(function()use($maDiaChi){
            if(AddressService::delete($maDiaChi) != false)
                return ResponseJson::success("Xóa địa chỉ thành công");
            return ResponseJson::failed("Bạn không có quyền xóa địa chỉ này");                        
        });
    }
}
