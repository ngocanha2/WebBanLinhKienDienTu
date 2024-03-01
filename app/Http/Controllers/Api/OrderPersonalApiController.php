<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Services\OrderPersonalService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderPersonalApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {        
        return Call::TryCatchResponseJson(function()use($request){
            return OrderPersonalService::getDataOrderWithStatus($request->status);
        });
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {        
        return Call::TryCatchResponseJson(function()use($id){
            return OrderPersonalService::show($id);
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function cancelOrder($id, Request $request)
    {
        return Call::TryCatchResponseJson(function()use($id,$request){
            return OrderPersonalService::cancelOrder($id,$request->all());
        });
    }
}
