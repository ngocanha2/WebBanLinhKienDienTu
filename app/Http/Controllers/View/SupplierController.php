<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\chitietdathang;
use App\Models\phieudathang;
use App\Services\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    public function index()
    {
        return view("manager.supplier.supplier_index");
    }
    public function provide()
    {

        return view("manager.supplier.supplier_provide");
    }
    public function order()
    {
        return view("supplier.order",[
            "orders"=>phieudathang::all()
        ]);
    }
    public function supplyOrder()
    {
        return view("manager.supply-order.supply_order_history",[
            "orders"=>phieudathang::all()
        ]);
    }
    public function handle($orderNumber)
    {
        $order = phieudathang::find($orderNumber);  
        $orderDetails = SupplierService::orderDetailsWithDeliveryStatus($orderNumber,["Chờ xác nhận","Đã xác nhận"]);
        return view("supplier.handle",[
            "order"=>$order,
            "orderDetails"=>$orderDetails
        ]);
    }
}
