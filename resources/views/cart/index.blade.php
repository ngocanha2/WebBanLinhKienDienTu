@extends('layouts.app')
<style>
    .box-center{
        top: 20%;
    }
</style>
@section('content')
{{-- <script src="{{ asset('js/callapi/cart/cart.js') }}"></script> --}}
<script src="{{ asset('js/callapi/order/order.js') }}"></script>
<style>
    .item {
        background-color: white;
        border-radius: 5px;
        box-shadow: 1px 4px 7px #AAAAAA;
    }

    .hienthi_sl {
        margin-left: -6px;
        margin-right: -6px;
        height: 38px;
        width: 60px;
        border: 1px solid #CBCBCB;
        text-align: center;
        border-radius: 0px;
    }

        .hienthi_sl:hover {
            border: 1px solid #0dcaf0;
        }

        .hienthi_sl:focus {
            border: 1px solid #0dcaf0;
        }

    .dropdown:hover .gg {
        background-color: red;
        color: white;
    }

    .cong {
        border-top-left-radius: 5px;
        border-bottom-left-radius: 5px;
        border-top-right-radius: 0px !important;
        border-bottom-right-radius: 0px !important;
    }

    .tru {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
        border-top-left-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
    }

    .rdo_all {
        width: 20px;
        height: 20px;
        margin-top: 10px;
        margin-right: 10px;
        cursor: pointer;
    }

    #TongTien {
        color: crimson;
        font-size: 25px;
        font-weight: bold;
    }

    .muangay:hover {
        border-radius: 5px;
        box-shadow: 1px 4px 7px #AAAAAA;
        border: 1px solid black;
    }

    .rdo_all:hover,
    .CHKSP:hover {
        box-shadow: 1px 4px 7px #AAAAAA;
    }

    .rdo_all.bg-info {
        box-shadow: 1px 4px 7px #0dcaf0;
        border: 1px solid #000000;
    }

    .loi_sl {
        color: crimson;
        position: absolute;
        font-size: 13px;
        bottom: -30px;
        display: none;
    }
    a{
        text-decoration:none;
        color:black;
    }
    .item-product{
        position: relative;  
        border: 1px solid #CBCBCB;     
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .item-product-details{
        padding: 20px;        
    }
    .item-product-remove{
        position: absolute;
        border: 1px solid #fc3737;
        border-top-right-radius:10px;
        background-color: #ffc7c7;       
        width: 50px;
        height: 50px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        top: -1;
        right: -1;
        cursor: pointer;
        opacity: 0;
    }
    .item-product:hover .item-product-remove{
        opacity: 1;
    }
    .item-product-remove:hover{
        background-color: #ff4242;
        color: #000000;
    }
    .product-price-sale{
        color: #808080;
        text-decoration: line-through;
    }
</style>
<div class="container-lg p-lg-5">
    <div class="row" style="margin-top:10px ;">
        <div class="left col-xl-8 item" style="padding:4px;">
            <div class="box-btn-delete-all-cart">

            </div>
                <div id="box_show_carts" style="border-radius: 10px; padding: 20px; margin: 0px; margin-bottom: 8px;">                        

                    
                        <div class="row item-product" >
                            <div class="item-product-remove">                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>                                
                            </div>
                            <div class="row item-product-details">
                                <a href="#" class="col-12 col-lg-6 row" style="margin-bottom:20px;">
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input value="123" class="form-check-input CHKSP " type="checkbox" />
                                            </div>
                                            <div class="col-9">
                                                <img src="123.jgb" style="width:100%; min-height:100px ; border:1px solid black">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        Tên sản phẩm
                                        <p style="color:#808080; font-size:13px;">loại: 123</p>
                                    </div>
                                </a>
                                <div class="col-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6 gia">
                                            <center><h4 class="giasp" title="123" style="color:crimson">1000.000.000đ</h4></center>
                                        </div>
                                        <div class="col-md-6 " style="text-align:center; justify-content:center; align-items:center;">
                                            <div>
                                                <a class="sl btn btn-outline-info cong">+</a>
                                                <input type="text" name="123" class="hienthi_sl btn" max="123" value="123" />
                                                <a class="sl btn btn-outline-info tru">-</a>
                                            </div>
                                        </div>                                   
                                    </div>
                                    <div style="position:relative;">
                                        <span style="" class="loi_sl">Vui lòng nhập đủ số lượng nếu bạn muốn mua sản phẩm này!</span>
                                    </div>
                                </div>  </div>                          
                        </div>
                        
                        <div class="row item-product" >
                            <div class="item-product-remove">                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>                                
                            </div>
                            <div class="row item-product-details">
                                <a href="#" class="col-12 col-lg-6 row" style="margin-bottom:20px;">
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input value="123" class="form-check-input CHKSP " type="checkbox" />
                                            </div>
                                            <div class="col-9">
                                                <img src="123.jgb" style="width:100%; min-height:100px ; border:1px solid black">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        Tên sản phẩm
                                        <p style="color:#808080; font-size:13px;">loại: 123</p>
                                    </div>
                                </a>
                                <div class="col-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6 gia">
                                            <center><h4 class="giasp" title="123" style="color:crimson">1000.000.000đ</h4></center>
                                        </div>
                                        <div class="col-md-6 " style="text-align:center; justify-content:center; align-items:center;">
                                            <div>
                                                <a class="sl btn btn-outline-info cong">+</a>
                                                <input type="text" name="123" class="hienthi_sl btn" max="123" value="123" />
                                                <a class="sl btn btn-outline-info tru">-</a>
                                            </div>
                                        </div>                                   
                                    </div>
                                    <div style="position:relative;">
                                        <span style="" class="loi_sl">Vui lòng nhập đủ số lượng nếu bạn muốn mua sản phẩm này!</span>
                                    </div>
                                </div>  </div>                          
                        </div>  

                        <div class="row item-product" >
                            <div class="item-product-remove">                                
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
                                </svg>                                
                            </div>
                            <div class="row item-product-details">
                                <a href="#" class="col-12 col-lg-6 row" style="margin-bottom:20px;">
                                    <div class="col-4">
                                        <div class="row">
                                            <div class="col-3">
                                                <input value="123" class="form-check-input CHKSP " type="checkbox" />
                                            </div>
                                            <div class="col-9">
                                                <img src="123.jgb" style="width:100%; min-height:100px ; border:1px solid black">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        Tên sản phẩm
                                        <p style="color:#808080; font-size:13px;">loại: 123</p>
                                    </div>
                                </a>
                                <div class="col-12 col-lg-6">
                                    <div class="row">
                                        <div class="col-md-6 gia">
                                            <center><h4 class="giasp" title="123" style="color:crimson">1000.000.000đ</h4></center>
                                        </div>
                                        <div class="col-md-6 " style="text-align:center; justify-content:center; align-items:center;">
                                            <div>
                                                <a class="sl btn btn-outline-info cong">+</a>
                                                <input type="text" name="123" class="hienthi_sl btn" max="123" value="123" />
                                                <a class="sl btn btn-outline-info tru">-</a>
                                            </div>
                                        </div>                                   
                                    </div>
                                    <div style="position:relative;">
                                        <span style="" class="loi_sl">Vui lòng nhập đủ số lượng nếu bạn muốn mua sản phẩm này!</span>
                                    </div>
                                </div>  </div>                          
                        </div>  
                                                           





                </div>  
                
                

        </div>
        <div class="col-xl-4 col-12 " style="padding:4px;">
            <div class="row item w-100" style="border-radius: 10px; background-color: #fff; padding: 15px;  min-height:260px; margin:0px; position:sticky; top:110px;">
                <div class="col-12">
                    {{-- <a style="color:black;outline: none; border: none;background-color: transparent; font-size: 20px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-currency-exchange" viewBox="0 0 16 16">
                            <path d="M0 5a5.002 5.002 0 0 0 4.027 4.905 6.46 6.46 0 0 1 .544-2.073C3.695 7.536 3.132 6.864 3 5.91h-.5v-.426h.466V5.05c0-.046 0-.093.004-.135H2.5v-.427h.511C3.236 3.24 4.213 2.5 5.681 2.5c.316 0 .59.031.819.085v.733a3.46 3.46 0 0 0-.815-.082c-.919 0-1.538.466-1.734 1.252h1.917v.427h-1.98c-.003.046-.003.097-.003.147v.422h1.983v.427H3.93c.118.602.468 1.03 1.005 1.229a6.5 6.5 0 0 1 4.97-3.113A5.002 5.002 0 0 0 0 5zm16 5.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0zm-7.75 1.322c.069.835.746 1.485 1.964 1.562V14h.54v-.62c1.259-.086 1.996-.74 1.996-1.69 0-.865-.563-1.31-1.57-1.54l-.426-.1V8.374c.54.06.884.347.966.745h.948c-.07-.804-.779-1.433-1.914-1.502V7h-.54v.629c-1.076.103-1.808.732-1.808 1.622 0 .787.544 1.288 1.45 1.493l.358.085v1.78c-.554-.08-.92-.376-1.003-.787H8.25zm1.96-1.895c-.532-.12-.82-.364-.82-.732 0-.41.311-.719.824-.809v1.54h-.005zm.622 1.044c.645.145.943.38.943.796 0 .474-.37.8-1.02.86v-1.674l.077.018z" />
                        </svg> Ưu đãi
                    </a>
                    <a class="btn btn-outline-info" style="float:right" data-bs-toggle="modal" data-bs-target="#ChonVoucher">
                        Chọn/Nhập mã
                    </a> --}}
                    <div style="clear:both"></div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            Tổng:
                        </div>
                        <div class="col-8">
                            <center><span id="total_quantity">0</span> </center>
                        </div>
                        <div class="col-4">
                            Tạm tính:
                        </div>
                        <div class="col-8">
                            <center><span id="total_price">0</span>đ</center>
                        </div>
                    </div>
                </div>
                <button class="btn btn-info w-100 muangay" id="btn_build_order" style="height:60px; font-size:25px; padding-bottom:10px;">Đặt Hàng</button>
            </div>
        </div>
    </div>                                        
  
</div>
<script src="{{ asset('js/handle/cart/cart.js') }}"></script>
@endsection