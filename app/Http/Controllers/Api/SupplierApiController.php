<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Services\SupplierService;
use Illuminate\Http\Request;

class SupplierApiController extends Controller
{
   /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {                
        return Call::TryCatchResponseJson(function() use ($request) 
        {
            $data = SupplierService::all($request->status);
            return ResponseJson::success(data:$data);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {        
        return Call::TryCatchResponseJson(function() use ($request) 
        {
            $data = SupplierService::create($request->all());
            return ResponseJson::success(data:$data);
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
    public function update(SupplierRequest $request, string $id)
    {        
        return Call::TryCatchResponseJson(function() use ($request,$id) 
        {
            $data = SupplierService::update($id,$request->all());
            if($data==false)
                return ResponseJson::errors(["Mã nhà cung cấp không tồn tại"]);            
            return ResponseJson::success(data:$data);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {        
        return Call::TryCatchResponseJson(function() use ($id) 
        {
            $data = SupplierService::delete($id);            
            if($data > 0)
                return ResponseJson::success("Xóa nhà cung cấp thành công");
            if($data==0)
                return ResponseJson::error("Mã nhà cung cấp không tồn tại");          
            return ResponseJson::error("Không thể xóa, Nhà cung cấp hiện đang có nguồn cung");
            
        });
    }
}
