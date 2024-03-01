

{{-- @extends('layouts.app') --}}
@extends('supplier.layout')
@section('content')
<style>
    .tr-change td{
        /* border: 1px solid red; */
        background-color: #87d2e9;
    }
</style>
<br><br><br><br>
<div class="container">
    <a href="/supplier/order">Trở về</a>
    <div class="box-white" style="padding:20px; background-color: white; ">
        <div >
            <center><h3>Thông tin phiếu đặt hàng</h3></center>
            <div class="row">
                <div class="col-lg-6 col-12">
                    <span>Số phiếu đặt: {{$order->SoPhieuDatHang}}</span><br>
                    <span>Nhà cung cấp: {{$order->MaNCC}}</span><br>
                    <span>Ngày đặt: {{$order->NgatDat}}</span>                    
                </div>
                <div class="col-lg-6 col-12">
                    <span>Tổng số lượng: {{$order->TongSL}}</span><br>
                    <span>Thành tiền: {{$order->ThanhTien}}</span>
                </div>
            </div>
        </div>
        <center><h4>Chi tiết phiếu đặt hàng</h4></center>
        @php
            $count = 0;
        @endphp
        <table class="table table-hover table-striped table-bordered" border="1">
            <tr>
                <th>Mã hàng</th>
                <th>Tên hàng</th>
                <th>Số lượng đặt</th>
                <th>Số lượng đã giao</th>
            </tr>                        
            @foreach ($orderDetails as $orderDetail) 
            <tr>
                <td>{{$orderDetail->MaHang}}</td>                                
                <td>{{$orderDetail->TenHang}}</td>                
                <td>{{$orderDetail->SoLuong}}</td>                                               
                <td>{{$orderDetail->SoLuongDaGiao}}</td> 
            </tr>
            @endforeach
        </table>
        <div id="box-delivery">
            <center><h4>Tiến hành giao hàng</h4></center>
            <div class="row">
                <div class="box-information-input col-lg-4 col-md-6">
                    <label for="select-product" class="information-label">Chọn hàng hóa</label>
                    <select id="select-product" class="information-input readonly" name="MaHang">
                        @foreach ($orderDetails as $orderDetail)
                            @if ($orderDetail->SoLuong - $orderDetail->SoLuongDaGiao > 0)
                                @php
                                    $count++;
                                @endphp
                                <option value="{{$orderDetail->MaHang}}" max-value="{{$orderDetail->SoLuong - $orderDetail->SoLuongDaGiao}}" product-name="{{$orderDetail->TenHang}}">{{$orderDetail->MaHang}} - {{$orderDetail->TenHang}}</option>                        
                            @endif
                    @endforeach
                    </select>
                    <span class="error-information" id="error-select-product"></span>
                </div>    
                <div class="box-information-input col-lg-4 col-md-6">
                    <label for="quantity" class="information-label">Nhập số lượng</label>
                    <input type="number" class="information-input " id="quantity">
                    <span class="error-information" id="error-select-product"></span>
                </div>    
                <div class="box-information-input col-lg-4">
                    <center>
                        <button class="btn btn-info" id="btn-update">Thêm</button>                    
                        <button class="btn btn-outline-info" id="btn-cancel">Hủy</button>
                        <button class="btn btn-warning"  id="btn-submit">Tạo phiếu giao</button>
                    </center>
                </div>
            </div>
            
            <table class="table table-hover table-striped table-bordered" border="1">
                <tr>
                    <th>Mã hàng</th>
                    <th>Tên hàng</th>
                    <th>Số lượng giao</th>                
                    <th></th>
                </tr>
                <tbody id="delivery-note-details">

                </tbody>
            </table>
        </div>       
    </div>
    @if ($count == 0)
    <script>
        $("#box-delivery").html(`<center><h3>Đơn hàng đã giao đủ số lượng</h3></center>`)
    </script>
    @else
        <script src="{{asset("js/handle/supplier/supplier_handle.js")}}"></script>
    @endif
</div>
@endsection

