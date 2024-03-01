<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Services\GuaranteeService;
use Illuminate\Http\Request;

class GuaranteeApiController extends Controller
{
    public function store($maDonHang,$maHang,Request $request)
    {        
        return Call::TryCatchResponseJson(function()use($maDonHang,$maHang,$request){
            return GuaranteeService::store($maDonHang,$maHang,$request->all());
        });
    }
    public function index($maDonHang,$maHang)
    {        
        return Call::TryCatchResponseJson(function()use($maDonHang,$maHang){
            return GuaranteeService::all($maDonHang,$maHang);
        });
    }
    public function unprocessed($maDonHang,$maHang)
    {        
        return Call::TryCatchResponseJson(function()use($maDonHang,$maHang){
            return GuaranteeService::unprocessed($maDonHang,$maHang);
        });
    }
    
    public function update($id,Request $request)
    {
        return Call::TryCatchResponseJson(function()use($id, $request){
            return GuaranteeService::update($id,$request->all());
        });
    }
    public function destroy($id)
    {
        return Call::TryCatchResponseJson(function()use($id){
            return GuaranteeService::delete($id);
        });
    }
}
