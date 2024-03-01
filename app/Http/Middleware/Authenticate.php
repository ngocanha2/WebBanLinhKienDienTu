<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {                       
        if($request->expectsJson())        
            return null;              
        $user = Session::get("admin");                        
        if(isset($user))
        {
            Auth::guard("admin-api")->login($user);
            return route("statistical");
        }            
        Session::put(config("app.URL_INTENDED",'url_intended'), url()->current());  
        return route('login');
    }
}
