<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Http\Controllers\RespositoryControllers\UserRepositoryController;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserApiController extends UserRepositoryController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
        return UserService::getPaginated($this->userRepo,$request->perpage);
        });
    }
    public function infomation()
    {
        return Call::TryCatchResponseJson(function(){
            return ResponseJson::success(data:Auth::user());
        });
    }
    public function changePassword(Request $request)
    {
        return Call::TryCatchResponseJson(function() use($request){
            $user = Auth::user();
            return UserService::updatePassword($this->userRepo,$request->all(), $user);
        });
    }
    public function update(Request $request)
    {
        return Call::TryCatchResponseJson(function()use($request){
            $user = Auth::user();
            return UserService::update($this->userRepo,$request->all(), $user);
        });        
    }
}
