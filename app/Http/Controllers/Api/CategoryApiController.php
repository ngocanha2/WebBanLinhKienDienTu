<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Call::TryCatchResponseJson(function(){
            return CategoryService::all();
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Call::TryCatchResponseJson(function() use($request){
            return CategoryService::store($request->all());
        });
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return Call::TryCatchResponseJson(function() use($id,$request){
            return CategoryService::update($id,$request->all());
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Call::TryCatchResponseJson(function() use($id){
            return CategoryService::delete($id);
        });
    }
}
