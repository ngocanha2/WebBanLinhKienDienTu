<?php

use App\Http\Controllers\Api\AddressPersonalApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\DeliveryApiController;
use App\Http\Controllers\Api\EmailApiController;
use App\Http\Controllers\Api\FeatureApiController;
use App\Http\Controllers\Api\FeedbackApiController;
use App\Http\Controllers\Api\GuaranteeApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\OrderPersonalApiController;
use App\Http\Controllers\Api\OrderStoreApiController;
use App\Http\Controllers\Api\PermissionApiController;
use App\Http\Controllers\Api\PremiumApiController;
use App\Http\Controllers\Api\PremiumFeatureApiController;
use App\Http\Controllers\Api\PromotionApiController;
use App\Http\Controllers\Api\QRCodeApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\ShortLinkApiController;
use App\Http\Controllers\Api\ShortLinkManagerApiController;
use App\Http\Controllers\Api\ShortLinkPersonalApiController;
use App\Http\Controllers\Api\SupplierApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\SupplierManagerApiController;
use App\Http\Controllers\Api\SupplierSourceGoodsApiController;
use App\Http\Controllers\Api\SupplyOrderApiController;
// use App\Http\Controllers\GuaranteeController;
use App\Http\Controllers\View\OrderStoreController;
use App\Http\Controllers\View\SupplyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View\GuaranteeController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post("/verify/{id}/{token}",[
    EmailApiController::class,
    "verifyEmail"
]);
Route::group(['middleware'=>['api']],function($request){
    Route::group(['prefix'=>'auth'],function(){
        route::post('/login',[
            AuthApiController::class,
            'login'
        ]);
        Route::get('logout', [
            AuthApiController::class,
            'logout'
        ]);//->name("logout");
        Route::post('refresh', [
            AuthApiController::class,
            'refresh'
        ]);
        Route::post('me', [
            AuthApiController::class,
            'me'
        ]);
        Route::post('register', [
            AuthApiController::class,
            'register'
        ]);
    });
    
    
    // Route::apiResource("cart",CartApiController::class);
    Route::group(['prefix'=>'cart'],function(){
        Route::controller(CartApiController::class)->group(function(){                             
            Route::get("/","index");
            Route::get("/quantity","getQuantity");
            Route::post("/","store");
            Route::put("/","update");
            Route::delete("/","destroy");
            Route::patch("clear","deleteAll");        
        });        
    });
    
    Route::group(['prefix'=>'order'],function(){
        Route::controller(OrderApiController::class)->group(function(){                             
            Route::post("build","buildOrder");
            Route::get("checkout","checkout");                   
            Route::post("checkout","submitOrder");                   
        });        
    });
    // Route::group(['prefix'=>'personal','middleware'=>['auth:user-api']],function () {         
    // });
    // Route::controller(PremiumFeatureApiController::class)->group(function(){
    //     Route::group(["prefix"=> "premium-feature"],function(){
    //         Route::get("get-by-premium","getByPremium")->name("api.manager-premium-feature-get-by-premium");
    //     });
    // });
    Route::group(['middleware'=>['auth.jwt']],function(){ 
        Route::group(['middleware'=>['admin-ui']],function(){ 
            Route::post('/insert-supply-order', [SupplyController::class, 'themHoaDon']);                                         
            Route::group(['prefix'=>'manager'],function(){

                Route::group(['prefix'=>'mail'],function(){
                    Route::controller(EmailApiController::class)->group(function(){                             
                        Route::post("mass-mail","sendMassMail");                  
                    });        
                });                

                Route::group(['prefix'=>'supply-order'],function(){
                    Route::controller(SupplyOrderApiController::class)->group(function(){                             
                        Route::get("/{id}","show");                  
                    });        
                });
                Route::group(['prefix'=>'order'],function(){
                    Route::controller(OrderStoreApiController::class)->group(function(){                             
                        Route::patch("/{id}/refuse","updateStatusCancel");                      
                    });        
                });

                route::apiResource('promotion', PromotionApiController::class);
            
                Route::apiResource("supplier",SupplierApiController::class);
                Route::apiResource("category",CategoryApiController::class);

                // Route::apiResource("source-goods/{maNhaCungCap}",SupplierSourceGoodsApiController::class);
                Route::group(['prefix'=>'source-goods'],function(){
                    Route::controller(SupplierSourceGoodsApiController::class)->group(function(){                             
                        Route::get("{maNhaCungCap}","index");                      
                        Route::post("{maNhaCungCap}","store");                      
                        Route::put("{maNhaCungCap}/{maHang}","update");                      
                        Route::delete("{maNhaCungCap}/{maHang}","destroy");                      
                    });        
                });             
                

                route::resource('users', UserApiController::class)->names([
                    "index"=>"api.manager-users-index",
                    "update"=>"api.manager-users-update",
                    "destroy"=>"api.manager-users-delete",
                ]);  
                route::delete('users',[
                        UserApiController::class,
                        "deletes"
                    ])->name("api.manager-users-deletes");            
            });  
        }); 
        Route::apiResource("delivery",DeliveryApiController::class)->only(["index","show","destroy"]);
        Route::group(['prefix'=>'delivery'],function(){
            Route::controller(DeliveryApiController::class)->group(function(){                             
                Route::patch("/{soPhieuGiao}","confirmStatus");  
                Route::get("/{orderNumber}/waiting-confirm","orderDetailsWithDeliveryStatusWaitingConfirm");
            });        
        });          
    });


    Route::group(['prefix'=>'personal','middleware'=>"auth:user-api"],function(){
        Route::post("resend-verify-email",[
            EmailApiController::class,
            "reSendVerifyEmail"
        ]);  
        Route::get("infomation",[
            UserApiController::class,
            "infomation"
        ])->name("api.personal-infomation");    
        Route::put("infomation",[
            UserApiController::class,
            "update"
        ])->name("api.personal-infomation-update");  
        Route::put("change-password",[
            UserApiController::class,
            "changePassword"
        ])->name("api.personal-infomation-change-password"); 
        Route::group(['prefix'=>'guarantee'],function(){
            Route::controller(GuaranteeApiController::class)->group(function(){                                                 
                Route::get("{maDonHang}/{maHang}","index");
                Route::get("{id}","unprocessed");
                Route::post("{maDonHang}/{maHang}","store");
                Route::put("{id}","update");                    
                Route::delete("{id}","destroy");                   
            });        
        });          
        
        Route::group(['prefix'=>'address'],function(){
            Route::controller(AddressPersonalApiController::class)->group(function(){                             
                Route::get("/","index");
                Route::post("/","store");
                Route::put("{maDiaChi}","update");
                Route::put("{maDiaChi}/set-default","updateDefault"); 
                Route::delete("{maDiaChi}","destroy");                   
            });        
        });
        Route::group(['prefix'=>'order'],function(){
            Route::controller(OrderPersonalApiController::class)->group(function(){                             
                Route::get("","index");
                Route::get("/{id}","show");                   
                Route::patch("/{id}/cancel","cancelOrder")->withoutMiddleware("auth:user-api");
                // Route::put("{maDiaChi}","update");
                // Route::put("{maDiaChi}/set-default","updateDefault"); 
                // Route::delete("{maDiaChi}","destroy");                   
            }); 
            Route::post("/{maDonHang}/{maHang}/feedback",[
                FeedbackApiController::class,
                "store"
            ]);
        });

        Route::controller(QRCodeApiController::class)->group(function(){
            Route::get('qrcode/{shortened_link}',"show")->name("api.personal-qrcode-show");        
        });                           
    });
    Route::group(['prefix'=>'supplier'],function(){        
        Route::post("{orderNumber}/handle",[
            SupplierManagerApiController::class,
            'handle'            
        ]);        
    });   
        
    Route::post('/insert-detailt-supply-order', [SupplyController::class, 'themChiTietHoaDon']);

    // Route::put('/updateStatusGuarantee/{idDH}/{idHH}/{tt}',[
    //     GuaranteeController::class, 'updateStatus'   
    // ]);
    
});