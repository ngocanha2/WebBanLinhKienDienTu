@extends('layouts.layoutdashboard')
@section('content')
<style>
    .btn_Them
    {
        width: 50%;
        margin-top: 25px;
        background-color: rgb(166, 208, 229);
        color: white;
        
    }
    .btn_Them:hover
    {
        background-color: rgb(107, 185, 211);
    }
    .img:hover
    {
        scale: 1.2
    }
    
</style>
    
<!-- tạo menu -->
<div class="container">
    <div class="col-md-12" style="margin-left: 0">
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


     <div class="col-12" style="background-color: white; border-radius: 10px; margin: 0 auto; margin-top: 30px; ">
        <div class="row" style="width: 100%; margin-top: 5px"><a href="http://127.0.0.1:8000/insertproductstore"><button style="height: 50px; width: 100%; border-radius: 10px; font-size: 20px;" class="btn_Them">Thêm sản phẩm</button></a></div>
        
        <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px; align-content:center;text-align:center;justify-content:center;align-items:center;">
            <thead>
                <tr>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá bán</th>
                    <th>Số lượng tồn</th>
                    <th>Thời gian bảo hành</th>
                    <th>Thao tác</th>
                </tr>
                @foreach($hanghoas as $sp)
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
                        <td><img class="img" src = "{{ asset('images/'. $sp->HinhAnh)}}" style="width: 50px; height: 50px;"></td>
                        <td style="text-align: center">{{$sp->TenHang}}</td>
                        <td style="text-align: center">{{$sp->GiaBan}}VNĐ</td>
                        <td>{{$sp->SoLuongTon}}</td>
                        <td>{{$sp->ThoiGianBaoHanh}} tháng</td>
                        <td><a href="{{ route('detail-product-store', ['id'=>$sp->MaHang])}}"><button class="btn btn-warning" style="width: 100px;">Chi tiết</button></a><br><br>
                            <a href="{{ route('delete-product-store', ['id'=>$sp->MaHang])}}"><button class="btn btn-danger" style="width: 100px;">Xóa</button></a><br><br>
                        </td>
                </tr>
                @endforeach
            </thead>
        </table>
    </div>
        </div>
      </div>  
</div>
@endsection