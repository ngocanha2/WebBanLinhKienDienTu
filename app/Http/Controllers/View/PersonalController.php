<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalController extends Controller
{    
    public function index()
    {
        return view("personal.index");
    }    
    public function infomation()
    {
        return view("personal.infomation");
    }
    public function orderView()
    {
        return view("personal.order.order_index");
    }
    public function orderDetailsView()
    {
        return view("personal.order.order_details");
    }
}
