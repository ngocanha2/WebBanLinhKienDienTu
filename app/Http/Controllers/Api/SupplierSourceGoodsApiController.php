<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Services\SupplierSourceGoodsService;
use Illuminate\Http\Request;

class SupplierSourceGoodsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($maNhaCungCap, Request $request)
    {
        return Call::TryCatchResponseJson(function()use($maNhaCungCap,$request){
            return SupplierSourceGoodsService::gets($maNhaCungCap);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($maNhaCungCap,Request $request)
    {
        return Call::TryCatchResponseJson(function()use($maNhaCungCap,$request){
            return SupplierSourceGoodsService::store($maNhaCungCap,$request);
        });
    }


    /**
     * Update the specified resource in storage.
     */
    public function update($maNhaCungCap, string $id,Request $request)
    {
        return Call::TryCatchResponseJson(function()use($maNhaCungCap,$id,$request){
            return SupplierSourceGoodsService::updatePrice($maNhaCungCap,$id,$request->GiaNhap);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maNhaCungCap, string $id)
    {
        return Call::TryCatchResponseJson(function()use($maNhaCungCap,$id){
            return SupplierSourceGoodsService::delete($maNhaCungCap,$id);
        });
    }
}
