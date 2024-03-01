<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeedbackRequest;
use App\Http\Requests\SupplierRequest;
use App\Services\FeedbackService;
use Illuminate\Http\Request;

class FeedbackApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }   
    public function store(FeedbackRequest $request,$maDonHang,$maHang)
    {        
        return Call::TryCatchResponseJson(function()use($request,$maDonHang,$maHang){
            return FeedbackService::createFeedback($maDonHang,$maHang,$request->all());
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
