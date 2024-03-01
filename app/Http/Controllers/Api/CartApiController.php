<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Call::TryCatchResponseJson(function(){
            return CartService::getCarts();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
            return CartService::insert($request->ma_hang,$request->so_luong);
        });
    }
   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return Call::TryCatchResponseJson(function() use ($request){
            return CartService::updateQuantity($request->ma_hang,$request->so_luong);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return Call::TryCatchResponseJson(function() use ($request){
            return CartService::delete($request->ma_hang);
        });
    }
    public function deleteAll()
    {
        return Call::TryCatchResponseJson(function(){
            return CartService::deleteAll();
        });
    }
    public function getQuantity()
    {
        return Call::TryCatchResponseJson(function(){
            return CartService::getQuantity();
        });
    }
}
