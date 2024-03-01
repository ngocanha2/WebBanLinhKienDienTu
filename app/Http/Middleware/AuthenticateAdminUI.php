<?php

namespace App\Http\Middleware;

use App\Repositories\Interface\PermissionRepositoryInterface;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateAdminUI
{    

    public function handle($request, Closure $next)
    {             
        // dd(1); 
        // $token = $request->cookie(config("app.TOKEN_AUTH","token"));
        // dd($token);
        // $user = JWTAuth::parseToken($token);
        // dd($user);               
        // $user = Auth::guard("user-api")->user();           
        // dd(Auth::guard("admin-api"));
        $user = Session::get("admin");        
        if (!$user) {
            $user = Auth::guard("user-api")->user();
            if(isset($user))
                return redirect("/");
            Session::put(config("app.URL_INTENDED",'url_intended'), url()->current());
            return redirect()->route("login");
        }
        Auth::guard("admin-api")->login($user);
        return $next($request);                
    }
}

