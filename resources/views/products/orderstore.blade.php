@extends('layouts.layoutdashboard')
@section('content')
<style>
    .btn_XemChiTiet:hover{
        background-color: rgb(249, 202, 210);
    }
</style>
    
<!-- tạo menu -->
<div class="banner">
    <div class="col-md-12">
        <div class="row">
          {{-- <div class="col-md-3">
            <div class="nav flex-column menu-category">
                <p class="nav-item menu-category-header" style="margin:0"><i class="bi bi-list"></i> Menu</p>
              <div class="nav-item">
              
              <a href="http://127.0.0.1:8000/productstore" style="text-decoration: none"><p class="nav-link-menu-category">Sản phẩm<i class="bi bi-arrow-right"></i></p></a>
              <a href="http://127.0.0.1:8000/orderstore" style="text-decoration: none"><p class="nav-link-menu-category">Đơn hàng<i class="bi bi-arrow-right"></i></p></a>
              </div>  
            </div>

             <!-- Danh sách sản phẩm-->
             
         </div> --}}

     <div class="col-12" style="border-radius: 10px; margin-top: 30px; background-color: white; min-height: 650px;">
        <h2 style="column-span:3; text-align: center; margin-top: 25px; color: brown"><b>THÔNG TIN ĐƠN HÀNG</b></h2>
        <div>
            
            <a href="http://127.0.0.1:8000/orderstore"><button style="margin-right: 10px; margin-left: 10px; border-radius: 5px" class="btn btn-{{request()->is('orderstore') ? 'warning' : 'info' }}">Tất cả</button></a>
            <a href="http://127.0.0.1:8000/order-store-confirm-mail"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-confirm-mail') ? 'warning' : 'info' }}">Chờ xác thực</button>
            <a href="http://127.0.0.1:8000/order-store-confirm"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-confirm') ? 'warning' : 'info' }}">Chờ xác nhận</button>
            <a href="http://127.0.0.1:8000/order-store-handle"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-handle') ? 'warning' : 'info' }}">Đang xử lý</button>
            <a href="http://127.0.0.1:8000/order-store-deliver"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-deliver') ? 'warning' : 'info' }}">Đang giao</button>
            <a href="http://127.0.0.1:8000/order-store-delivered"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-delivered') ? 'warning' : 'info' }}">Đã giao</button>
            <a href="http://127.0.0.1:8000/order-store-cancel"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-cancel') ? 'warning' : 'info' }}">Đã hủy</button></a>
            <a href="http://127.0.0.1:8000/order-store-refuse"><button style="margin-right: 10px; border-radius: 5px" class="btn btn-{{request()->is('order-store-refuse') ? 'warning' : 'info' }}">Bị từ chối</button></a>
        </div>
        <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px; align-content:center;text-align:center;justify-content:center;align-items:center;">
            <thead>
                <tr>
                    <th>Đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Thành Tiền</th>
                    <th>Trạng thái</th>
                    <th></th>

                </tr>
                @foreach ($donhangs as $dh)
                <?php
                    // if($dh->TrangThai == 0)
                    //     $trangThai  = "Chờ xác nhận";
                    // if($dh->TrangThai == 1)
                    //     $trangThai  = "Đang xử lý";
                    // if($dh->TrangThai == 2)
                    //     $trangThai  = "Đang giao";
                    // if($dh->TrangThai == 3)
                    //     $trangThai  = "Đã giao";
                    // if($dh->TrangThai == 4)
                    //     $trangThai  = "Đã hủy";
                 ?>
                <tr>
                        <td style="text-align: center">{{$dh->MaDonhang }}</td>
                        <td style="text-align: center">{{$dh->MaKH ?? "Khách" }}</td>
                        <td style="text-align: center">{{$dh->NgayMua }}</td>
                        <td style="text-align: center">{{$dh->ThanhTien }}VNĐ</td>
                        <td style="text-align: center">{{$dh->TrangThai}}</td>
                        <td><a href="{{ route('detail-order-store', ['id'=>$dh->MaDonhang])}}"><button style="border-color: orangered; border-radius: 5px; color: red; padding: 2px" class="btn_XemChiTiet">Chi tiết</button></a></td>
                </tr>
                @endforeach
            </thead>
            
        </table>
    </div>

        </div>
    </div>  
</div>
@endsection