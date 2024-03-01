<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\hanghoa;
use App\Models\khuyenmai;
use App\Services\PromotionService;
use Illuminate\Http\Request;

class PromotionApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {                
        return Call::TryCatchResponseJson(function() use ($request) 
        {
            $data = PromotionService::all($request->status);
            return ResponseJson::success(data:$data);
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromotionRequest $request)
    {        
        return Call::TryCatchResponseJson(function() use ($request) 
        {
            $data = PromotionService::create($request->all());
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
    public function update(PromotionRequest $request, string $id)
    {        
        return Call::TryCatchResponseJson(function() use ($request,$id) 
        {
            $data = PromotionService::update($id,$request->all());
            if($data==false)
                return ResponseJson::errors(["Mã khuyến mãi không tồn tại"]);            
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
            $data = PromotionService::delete($id);            
            if($data > 0)
                return ResponseJson::success("Xóa khuyễn mãi thành công");
            if($data==0)
                return ResponseJson::error("Mã khuyến mãi không tồn tại");          
            return ResponseJson::error("Không thể xóa, Khuyến mãi hiện đang có sản phẩm sử dụng");
            
        });
    }
}
