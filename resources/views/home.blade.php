<link href="{{ asset('css/styleListProduct.css') }}" rel="stylesheet">
@extends('layouts.app')
@section('content')
<div class="banner">
    @if (isset($searchOrder) && $searchOrder == true)
    <link rel="stylesheet" href="{{asset('css/order/order_details.css')}}">
        <div class="box-white w-100" style="min-height: 500px;">
        @if (isset($donHang))        
        {{-- {{dd($donHang)}} --}}
        <center><h3>Thông tin đơn hàng {{$donHang->token}}</h3></center>
            <div class="box-order-details">
                <div class="box-order-details-header">                    
                    <div class="box-order-details-header-right">
                        <span class="item-order-details-code-status"><span>Mã đơn hàng: </span><span class="item-order-details-code">{{$donHang->MaDonhang}}</span> - [<span class="item-order-details-status">{{$donHang->TrangThai}}</span>]</span>                       
                    </div>
                    <div style="clear: both"></div>
                </div>
                <div class="box-order-details-content">
                    <div class="box-order-details-content-buyer-info row">
                        <div class="col-lg-4 box-order-details-content-buyer-info-address">
                            <center class="address-title">Địa chỉ nhận hàng</center>
                            <div>
                                <strong class="info-address-name-phone text-dark"><span class="info-address-name">{{$donHang->TenNguoiNhan}}</span> | <span class="info-address-phone-number">{{$donHang->SDT}}</span></strong><br>
                                <span class="info-address-phone-number">Email: {{substr($donHang->Email,0,3)}}**********</span><br>
                                <span class="info-address-info">{{$donHang->DiaChiGiaoHang}}</span><br>
                                <span class="info-address-info">{{$donHang->DiaChiCuThe}}</span><br>                                
                                <span class="info-address-note">({{$donHang->GhiChu}})</span><br>
                                <span >Vận chyển: <span class="info-order-details-shipping-method">{{$donHang->PhuongThucVanChuyen}}</span></span>

                            </div>
                        </div>                                             
                    </div>
                    <div class="text-dark">Đặt hàng lúc: <span class="order-date">{{$donHang->NgayMua}}</span></div>
                    <div class="box-order-details-content-main">
                        <div class="box-order-info-shop">
                            <span class="item-order-shop-name text-dark">Chi tiết đơn hàng</span>                                                        
                            <div style="clear: both"></div>
                        </div>
                        <div class="box-order-details-products">
                            @foreach ($chiTietDonHangs as $chiTiet)
                            <div class="item-order-product">
                                <div class="row">
                                    <div class="col-lg-2 col-xxl-1 col-md-3 col-sm-4 col-5">
                                        <div class="image-product w-100 h-100" style="background: url({{ asset('images/' . $chiTiet->HinhAnh) }}); background-size: cover; ">                                                
                                        </div>
                                    </div>
                                    <div class="col-lg-10 col-xxl-11 col-md-9 col-sm-8 col-7">
                                        <strong class="item-product-name text-dark">{{$chiTiet->TenHang}}</strong><br>
                                        <span class="item-product-classify"> {{number_format($chiTiet->DonGia,0,',','.')}} VNĐ</span><br>
                                        <span class="item-product-quantity">x {{$chiTiet->SoLuong}}</span>
                                        <strong class="item-product-price">{{number_format(($chiTiet->DonGia * $chiTiet->SoLuong),0,',','.')}} VNĐ</strong>
                                    </div>
                                </div>
                            </div>
                            @endforeach                           

                        </div>
                        <div class="box-order-tatol-summary">
                            <div class="row text-dark">                                
                                <div class="col-8 title-tatol-summary">Thành tiền:</div>
                                <div class="col-4 tatol-summary into-money">{{number_format($donHang->ThanhTien,0,',','.')}} VNĐ</div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">                        
                        <div class="text-warning">Phương thức thanh toán: <span class="payment-method">{{$donHang->PhuongThucThanhToan}}</span></div>                        
                    </div>
                </div>
                <div class="box-order-details-footer">
                    @if($donHang->TrangThai == "Chờ xác thực" || $donHang->TrangThai == "Chờ xác nhận" || ($donHang->TrangThai == "Đang xử lý" && $donHang->PhuongThucThanhToan != "Thanh toán online"))
                        <script src="{{asset("js/handle/personal/order/eventcancelorder.js")}}"></script>                        
                        <script>
                            $(".box-order-details-footer").append(createBoxCancelOrder({{$donHang->MaDonhang}},true));
                        </script>                                            
                    @endif
                </div>                
            </div>                                
        @else
            <p class="no-result">Không tìm thấy đơn hàng nào</p>
        @endif
    </div>
    @else
        <div class="col-md-12">
            <div class="row">
            <div class="col-md-3 ">
                <div class="nav flex-column menu-category">                
                    <p class="nav-item menu-category-header" style="margin:0"><i class="bi bi-list"></i> DANH MỤC</p>
                <div class="nav-item">
                @foreach($danhmucs as $dm)
                <a href="{{ route('category', ['id' => $dm->MaDanhMuc]) }}" style="text-decoration: none;" > <p class="nav-link-menu-category"> {{$dm->TenDanhMuc}} <i class="bi bi-arrow-right"></i></p> </a> 
                @endforeach
                </div>  
                </div>
                
            </div>

        <div class="col-md-9" >
        <div class= "row" >
        @if (isset($hanghoas) && count($hanghoas) > 0)
            <div class="group-list-product">
            @foreach($hanghoas as $sp)                
                <div class="content-product">                
                    <a href="/product/{{$sp->MaHang}}"><img class="img-product" src="{{ asset('images/' . $sp->HinhAnh) }}" alt="Hình ảnh sản phẩm"></a>
                    <a href="/product/{{$sp->MaHang}}" style="text-decoration: none" class="name-procduct" >{{$sp->TenHang}} </a>
                    @if ($sp->GiaKhuyenMai!=$sp->GiaBan)
                        <span class="sale-product-price"> {{number_format($sp->GiaBan,0,',','.')}} VNĐ</span>  
                        <span class="discount-ratio">-{{$sp->TyLeGiamGia}}%</span>                            
                    @endif
                    <span class="cost-product"> {{number_format($sp->GiaKhuyenMai,0,',','.')}} VNĐ</span>
                    <div class="link-detail" title="Thêm vào giỏ hàng" onclick="addProductToCart('{{$sp->MaHang}}')">
                        <div class="box-shadow"></div>
                        <i class="bi bi-bag-plus-fill icon" style="font-size: 40px"></i>
                    </div>
                </div>                
            @endforeach
            </div>
            
        </div>
        
        
        </div>
        <script src="{{asset("js/handle/home/product.addtocart.js")}}"></script>
        @else
            <p class="no-result">Không tìm thấy sản phẩm nào</p>
        @endif
            </div>
        </div>
    @endif
     
</div>




@endsection