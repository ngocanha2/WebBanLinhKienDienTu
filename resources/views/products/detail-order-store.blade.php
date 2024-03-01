@extends('layouts.layoutdashboard')
@section('content')
    @foreach ($donhangs as $dh)
    
    <?php
    // dd($dh)
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
    <h1 style="margin-top: 30px; margin-left: 10%; margin-bottom: 20px;">Thông tin đơn hàng: <span style="color: red">{{$dh->MaDonhang }}</span></h1>

    <a href="{{ route('update-status-order-store', ['id'=>$dh->MaDonhang])}}"><button class="btn btn-danger" style="margin-left: 10%; font-size: 20px; display: none">{{$dh->TrangThai}}</button></a>
        <script src="{{asset("js/handle/manager/order/order.details.js")}}"></script>
        <button class="btn btn-warning" id="btn-refuse-order" style="font-size: 20px; display: none" data-bs-toggle="modal" data-bs-target="#modal-cancel-order">Từ chối đơn hàng</button></a>
        <script>
            createBoxRefuseOrder({{$dh->MaDonhang}})
        </script>
    @if($dh->TrangThai == "Chờ xác thực" || $dh->TrangThai == "Chờ xác nhận" || $dh->TrangThai == "Đang xử lý" || $dh->TrangThai == "Đang giao" || $dh->TrangThai == "Đã giao")
    <a href="{{ route('update-status-order-store', ['id'=>$dh->MaDonhang])}}"><button class="btn btn-danger" style="margin-left: 10%; font-size: 20px;">{{$dh->TrangThai}}</button></a>
    @endif
    @if($dh->TrangThai == "Chờ xác nhận" || $dh->TrangThai == "Chờ xác thực")
        <script src="{{asset("js/handle/manager/order/order.details.js")}}"></script>
        <button class="btn btn-warning" id="btn-refuse-order" style="font-size: 20px;" data-bs-toggle="modal" data-bs-target="#modal-cancel-order">Từ chối đơn hàng</button>
        <script>
            createBoxRefuseOrder({{$dh->MaDonhang}})
        </script>
    @endif

    <div class="col-md-11" style="margin-top: 30px; background-color: white; margin: 0 auto; border-radius: 10px;">
        <div style=" border: 1px solid; background-color: rgb(97, 179, 247); text-align: center; color: white; padding: 10px; margin-top: 10px;"><h3>THÔNG TIN ĐƠN HÀNG</h3></div>
        <div class="row" style="margin-left: 10px;">
            <div class="col-md-7">
                <p style="font-size: 20px;">Tên người nhận: {{ $dh->TenNguoiNhan }}</p>
                <p style="font-size: 20px;">Địa chỉ nhận hàng: {{ $dh->DiaChiGiaoHang }}</p>
                <p style="font-size: 20px;">Số điện thoại: {{ $dh->SDT }}</p>
                <p style="font-size: 20px;">Phương thức vận chuyển: {{ $dh->PhuongThucVanChuyen ?? ""}}</p>
                <p style="font-size: 20px;">Phương thức thanh toán: {{ $dh->PhuongThucThanhToan ?? ""}}</p>
            </div>
            <div class="col-md-5">
                <p style="font-size: 20px;">Ngày mua: <span>{{ $dh->NgayMua }}</span></p>
                <p style="font-size: 20px;"><b>Tổng tiền: <span style="color: red">{{ $dh->ThanhTien }} VNĐ</span></b></p>
                <p style="font-size: 20px; color: crimson"><b>Trạng thái: {{ $dh->TrangThai }}</b></p>
                @if ($dh->TrangThai == "Bị từ chối" || $dh->TrangThai == "Đã hủy")
                    <p>Ghi chú: {{ $dh->GhiChu }}</p>
                @endif
            </div>
        </div>
        @endforeach
        <div style=" border: 1px solid; background-color: rgb(97, 179, 247); text-align: center; color: white; padding: 10px;"><h3>CHI TIẾT ĐƠN HÀNG</h3></div>
        
        <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px;">
            <thead>
                <tr>
                    <th style="text-align: center; font-size: 20px;">Sản phẩm</th>
                    <th style="text-align: center; font-size: 20px;">Số lượng</th>
                    <th style="text-align: center; font-size: 20px;">Giá bán</th>
                
                    <th style="text-align: center; font-size: 20px;">Thành tiền</th>

                </tr>
                @foreach ($chitietdonhangs as $ctdh)
                    <?php
                        $thanhTien = $ctdh->SoLuong *  $ctdh->DonGia; 
                    ?>
                <tr>
                    <td><img class="img" src = "{{ asset('images/'. $ctdh->HinhAnh)}}" style="width:100px; height: 100px;"><p style="font-size: 20px;">{{ $ctdh->TenHang }}</p></td>
                    <td style="text-align: center; font-size: 20px;">{{$ctdh->SoLuong }}</td>
                    <td style="text-align: center; font-size: 20px;">{{$ctdh->DonGia }} VNĐ</td>
                    <td style="font-size: 20px;">{{$thanhTien}} VNĐ</td>
                </tr>
                @endforeach
            </thead>
            
        </table>
        <div class="row">
            <div class="col-md-5">
                <p style="font-size: 20px;">Số sản phẩm: <span style="color: grey">{{$sosp }}</span></p>
            </div>
            <div class="col-md-6">
                <p style="font-size: 20px;">Tổng số lượng: <span style="color: grey">{{$soluong }}</span></p>
            </div>
            
        </div>
    </div>

    <script>$("#menu-item-order").addClass("active")</script>
@endsection