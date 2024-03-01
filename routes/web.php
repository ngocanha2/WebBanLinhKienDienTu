<?php

use App\Http\Controllers\Api\AddressApiController;
use App\Http\Controllers\Api\AddressPersonalApiController;
use App\Http\Controllers\Api\PremiumApiController;
use App\Http\Controllers\Api\ShortLinkPersonalApiController;
use App\Http\Controllers\DeliveryController;

use App\Http\Controllers\ManagerController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\View\AddressController;
use App\Http\Controllers\View\AuthController;
use App\Http\Controllers\View\CartController;
use App\Http\Controllers\View\CategoryController;
use App\Http\Controllers\View\EmailController;
use App\Http\Controllers\View\EmployeeController;
use App\Http\Controllers\View\HomeController;
use App\Http\Controllers\View\OrderController;
use App\Http\Controllers\View\OrderStoreController;
use App\Http\Controllers\View\PermissionController;
use App\Http\Controllers\View\PersonalController;
use App\Http\Controllers\View\PremiumController;
use App\Http\Controllers\View\PremiumFeatureController;
use App\Http\Controllers\View\ProductsController;
use App\Http\Controllers\View\ProductStoreController;
use App\Http\Controllers\View\PromotionController;
use App\Http\Controllers\View\RoleController;
use App\Http\Controllers\View\ShortLinkController;
use App\Http\Controllers\View\ShortLinkManagerController;
use App\Http\Controllers\View\ShortLinkPersonalController;
use App\Http\Controllers\View\StatisticalController;
use App\Http\Controllers\View\SupplierController;
use App\Http\Controllers\View\SupplyController;
use App\Http\Controllers\View\UserController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\View\GuaranteeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/verify/{id}/{token}',[
    EmailController::class,
    "verifyEmail"
])->name("revify-email");
;

Route::group(['prefix'=>'auth'],function(){
    Route::get("login",[
        AuthController::class,
        "login"
    ])->name("login");
    Route::get("logout",[
        AuthController::class,
        "logout"
    ])->name("logout");
    Route::get("register",[
        AuthController::class,
        "register"
    ])->name("register");
});




Route::get("cart",[
    CartController::class,
    "index"
])->name("cart"); 

Route::group(['prefix'=>'order'],function(){
    Route::controller(OrderController::class)->group(function(){                             
        Route::get("checkout","checkout");
        Route::get("{key}/payment-online-success","paymentOnlineSuccess");
        Route::get("success","orderSuccess")->name("orderSuccess");              

    });        
});

Route::get("verify-order/{maDonHang}/{token}",[
    EmailController::class,
    "verifyOrder"
]);


// //Cần xem xét lại
// Route::group(['prefix'=>'cart'],function(){
//     Route::controller(PremiumController::class)->group(function(){                             
//         Route::get("show","show")->name("premium-show");        
//         Route::get("register-success","registerSuccess")->name('premium-register-success');        
//     });
// });

Route::middleware(["auth"])->group(function(){
    Route::group(['prefix'=>'personal'],function(){
        Route::get("home",[
            PersonalController::class,
            "index"
        ])->name("web.personal-home"); 

        Route::get("infomation",[
            PersonalController::class,
            "infomation"
        ])->name("personal-infomation"); 
        Route::get("address",[
            AddressController::class,
            "index"
        ])->name("personal-address");  

        Route::get("order",[
            PersonalController::class,
            "orderView"
        ])->name("personal-order"); 
        Route::get("order/{id}",[
            PersonalController::class,
            "orderDetailsView"
        ])->name("personal-order-details"); 
         
    });

    
});

Route::group(['prefix'=>'supplier'],function(){                    
    Route::get("order",[
        SupplierController::class,
        "order"
    ]);
    Route::get("{orderNumber}/handle",[
        SupplierController::class,
        "handle"
    ]);         
});



Route::middleware(["admin-ui"])->group(function(){
    Route::group(['prefix'=>'manager'],function(){  
        Route::get('user',[
            UserController::class,
            "index"
        ])->name("manager.user.index");          
        Route::prefix('promotion')->group(function(){
            Route::controller(PromotionController::class)->group(function(){            
                Route::get('/','index')->name("manager.promotion.index");
            });
        });
        Route::get("category",[
            CategoryController::class,
            "index"
        ]);
        Route::get("supplier",[
            SupplierController::class,
            "index"
        ])->name("web.supplier-index");  
        Route::get("supplier/provide",[
            SupplierController::class,
            "provide"
        ]);
        Route::get("supply-order",[
            SupplierController::class,
            "supplyOrder"
        ]);
        Route::get("delivery",[
            DeliveryController::class,
            "index"
        ])->name("web.delivery-index");              
    });
    //--------------------------------
    Route::get("admin/supply", [SupplyController::class, "getSupply"])->name('supply');                
    Route::get("admin/guarantee", [GuaranteeController::class, "getListGuarentee"])->name('guarantee');
    Route::get("admin/detailsSupplyOrder/{id}", [SupplyController:: class, "thongTinHoaDon"])->name('detailsSupplyOrder');
    Route::get("admin/detailguarantee/{id}", [GuaranteeController::class, "getDeTailsGuarantee"])->name('detailguarantee');
    Route::put('/updateStatusGuarantee/{id}/{tt}',[
        GuaranteeController::class, 'updateNexStatus'   
    ]);
    Route::get("/orderhandelguarantee/{id}", [GuaranteeController::class, "neworderhandelguarantee"])->name('orderhandelguarantee');
    Route::post("/insertorderhandelguarantee", [GuaranteeController::class, "themHoaDon"])->name('insertorderhandelguarantee');
    Route::put('/updateNextStatusGuarantee/{id}/{tt}',[
    GuaranteeController::class, 'updateNexStatus'   
]);
    Route::get("admin/detailorderhandelguarantee/{id}", [GuaranteeController::class,"xemChiTietHoaDonXuLy"])->name('detailorderhandelguarantee');

//--------------------------------------------
    Route::get("productstore", [ProductStoreController::class, "getList"])->name("productstore");
    Route::get("insertproductstore", [ProductStoreController::class, "viewInsertProduct"]);
    Route::post("/update-product-store/{id}", [ProductStoreController::class, "updateProduct"])->name("update-product-store");
    Route::get("/delete-product-store/{id}", [ProductStoreController::class, "deleteProduct"])->name("delete-product-store");
    Route::get("/detail-product-store/{id}", [ProductStoreController::class, "detailProduct"])->name("detail-product-store");
    Route::post("/insert-product-store", [ProductStoreController::class, "insertProduct"])->name("insert-product-store");

    Route::get("orderstore", [OrderStoreController::class, "getListOrder"])->name("orderstore");
    Route::get("order-store-confirm-mail", [OrderStoreController::class, "getListOrderWaitConfirmMail"]);
    Route::get("order-store-confirm", [OrderStoreController::class, "getListOrderWaitConfirm"]);
    Route::get("order-store-handle", [OrderStoreController::class, "getListOrderHandle"]);
    Route::get("order-store-deliver", [OrderStoreController::class, "getListOrderDeliver"]);
    Route::get("order-store-delivered", [OrderStoreController::class, "getListOrderDelivered"]);
    Route::get("order-store-cancel", [OrderStoreController::class, "getListOrderCancel"]);
    Route::get("order-store-refuse", [OrderStoreController::class, "getListOrderRefuse"]);
    Route::get("/detail-order-store/{id}", [OrderStoreController::class, "getDetailOrder"])->name("detail-order-store");
    Route::get("/update-status-order-store/{id}", [OrderStoreController::class, "updateStatus"])->name("update-status-order-store");

    //Route::get("statistical", [StatisticalController::class, "getChart"]);
    Route::get("statistical-search", [StatisticalController::class, "getList"])->name("statistical");



    Route::get("employee", [EmployeeController::class, "getList"])->name("manager.employee");
    // Route::get("employee", [EmployeeController::class, "getChucVu"]);
    Route::get("insert-employee", [EmployeeController::class, "viewInsert"]);
    Route::get("insert", [EmployeeController::class, "insertEmployee"])->name("insert");
    Route::get("/detail-employee/{id}", [EmployeeController::class, "getDetail"])->name("detail-employee");
    Route::get("/update-employee/{id}", [EmployeeController::class, "updateEmployee"])->name("update-employee");

    // Route::get("information-employee", [EmployeeController::class, "viewInformation"]);
    Route::get("information-employee", [EmployeeController::class, "getInformation"])->name("information-employee");
    Route::get("update-information", [EmployeeController::class, "updateEmployeeInfo"])->name("update-information");
    Route::get("change-password", [EmployeeController::class, "getViewPass"]);
    Route::get("change", [EmployeeController::class, "updatePass"])->name("change");
    Route::get("employee/{id}/resetPassword", [EmployeeController::class, "resetPassword"])->name("employee-resetPassword");
    

});







// của Ánh
Route::get("", [ProductsController::class, "getListProduct"]);
Route::get("/product/{id}", [ProductsController::class, "getDetailsProductById"])->name('product');
Route::get("/category/{id}", [ProductsController::class, "getDetailsProductByCatogery"])->name('category');
Route::get("search", [ProductsController::class, "searchProduct"])->name('search');



// Route::get("/orderhandelguarantee/{id}", [GuaranteeController::class, "neworderhandelguarantee"])->name('orderhandelguarantee');







