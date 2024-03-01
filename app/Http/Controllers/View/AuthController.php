<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view("home.login");
    }
    public function register()
    {
        return view("home.register");
    }
    public function logout()
    {
        if(Auth::guard('user-api')->check())
            Auth::guard('user-api')->logout();
        if(Auth::guard('admin-api')->check())
        {
            Auth::guard('admin-api')->logout();
            Session::remove("admin");
        }
        return redirect("/");
    }
}
