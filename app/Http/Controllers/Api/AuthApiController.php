<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Call;
use App\Helpers\ResponseJson;
use App\Http\Controllers\RespositoryControllers\UserRepositoryController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Interface\UserRepositoryInterface;
use App\Services\AuthService;
use App\Services\MailService;
use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class AuthApiController extends UserRepositoryController
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {        
        parent::__construct($userRepo);        
    }
    public function login(LoginRequest $request)
    {                               
        $loginAdmin = isset($request->login_admin) ? true: false; 
        $token = AuthService::login($this->userRepo,$request->fieldvalue,$request->password,$loginAdmin == 1);
        // return $token;
        if (!$token) {
            return ResponseJson::error("Unauthorized",401);
        }        
        return $this->respondWithToken($token,$loginAdmin == 1);
    }     

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth("user-api")->logout();
        auth("admin-api")->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$loginAdmin = false)
    {
        $guard = $loginAdmin ? "admin-api":"user-api";
        $url = Session::pull(config("app.URL_INTENDED",'url_intended'));
        if($url == route("login"))
            $url = null;
        $res = [
            "success"=>true,
            "data"=>[
                'url' => $url ?? ($loginAdmin ? route("statistical") : "/"),  
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth($guard)->factory()->getTTL()
            ]
            ];          
        $response = new Response($res);
        //$response->withCookie(cookie(config("app.TOKEN_AUTH","token_auth"), $token, auth()->factory()->getTTL()*60));
        return $response->cookie("token",$token,auth($guard)->factory()->getTTL());
        // return ResponseJson::success(data:[
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => auth()->factory()->getTTL()
        // ]);
    }

    public function register(RegisterRequest $request)
    {
        return Call::TryCatchResponseJson(function() use ($request){
            return AuthService::register($this->userRepo,$request->full_name, $request->email,$request->password);
        });
    }
    public function verifyEmail($id, string $token)
    {
        if(MailService::verificaEmail($id,$token))
            return view("auth.verifica_email_success");         
        return view("auth.verifica_email_fail"); 
    }
    
}
