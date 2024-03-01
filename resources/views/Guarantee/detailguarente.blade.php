<link href="{{ asset('css/jadeLight/guarentee.css') }}" rel="stylesheet">
@extends('layouts.layoutdashboard')
@section('content')
<style>
    .decribecontent{
        font-size: 22px;
        margin-left: 20px;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- {{ dd($datayeucaubaohanhs) }} --}}
<div style="margin-top:30px;padding: 40px; background-color: #FFF;">

    <h1 style="text-align: center; color: #a52a2a;"> THÔNG TIN BẢO HÀNH</h1>
   <div style="display: flex; float: row; gap:100px;">
        <div style="margin-top: 40px;">
            
        <h4><b>Thông tin khách hàng</b></h4>
                <div class="decribecontent" >
                    <p>Họ và tên: {{$datayeucaubaohanhs[0]->HoVaTen}} </p>
                    @if($datayeucaubaohanhs[0]->SDTKH == null)
                            <p>Số điện thoại: {{$datayeucaubaohanhs[0]->SDT}}</p>
                        @else
                            <p>Số điện thoại: {{datayeucaubaohanhs[0]->SDTKH}} </p>
                        @endif
                    <p>Email: {{$datayeucaubaohanhs[0]->emailKH}} </p>
                </div>

            </div>
            <div style="margin-top: 40px;">
            <h4><b>Thông tin đơn hàng</b></h4>
                <div class="decribecontent">
                
                    <p> Mã đơn hàng: {{$datayeucaubaohanhs[0]->MaDonhang}}</p>
                    <p>Ngày đặt hàng: {{$datayeucaubaohanhs[0]->NgayMua}}</p>
                </div>
            </div>
   </div>

    <div>
        
       <div style="display:flex; justify-content: space-between"> 
       <h4> <b>Thông tin sản phẩm </b></h4>
       @if($datayeucaubaohanhs[0]->DaXuLy==0)
            <p class="content-status bg-yellow"> <i class="bi bi-clock-fill"></i> Chờ xử lý</p>
        @elseif($datayeucaubaohanhs[0]->DaXuLy==1)
            <p class="content-status bg-green">Đang xử lý</p>
        @elseif($datayeucaubaohanhs[0]->DaXuLy==2)
            <p class="content-status bg-blue">Đã xử lý</p>
        @else
            <p class="content-status bg-gray">Đã hủy</p>
        @endif</div>
         <table class="table table-striped"> 
           <thead>
                <tr>
                <th scope="col"> Mã sản phẩm </th>
                <th scope="col"> Tên sản phẩm </th>
                <th scope="col"> Hình ảnh </th>
                <th scope="col"> Thời gian bảo hành </th>
                <th scope="col"> Lý do bảo hành</th>
                </tr>
           </thead>
           <tbody>
                <tr>
                    <td> {{$datayeucaubaohanhs[0]->MaHang}}</td>
                    <td> {{$datayeucaubaohanhs[0]->TenHang}}</td>
                    <td> {{$datayeucaubaohanhs[0]->HinhAnh}}</td>
                    <td> {{$datayeucaubaohanhs[0]->ThoiGianBaoHanh}}</td>
                    <td> {{$datayeucaubaohanhs[0]->NguyenNhanBaoHanh}}</td>
                </tr>
           </tbody>
           @if($datayeucaubaohanhs[0]->DaXuLy==2)
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align: right; padding: 20px;">
                            <a class="btn btn-success"
                            href='/admin/detailorderhandelguarantee/<?php echo $datayeucaubaohanhs[0]->id ?>'>
                                Chi tiết bảo hành - sửa chữa 
                            </a>
                        </td>
                    </tr>
                </tfoot>
           @endif
         </table>
         @if($datayeucaubaohanhs[0]->DaXuLy==0)
            <div>
                <button class="btn btn-warning" onclick="UpdateNextStatus()">Tiếp nhận</button>
                <button class="btn btn-danger" onclick="UpdateCancelStatus()">Hủy</button>
            </div>
        @elseif($datayeucaubaohanhs[0]->DaXuLy==1)
            <button class="btn btn-primary" onclick="redirectCreateOrderHandel()">Xác nhận </button>
            <button class="btn btn-secondary" onclick="UpdateCancelStatus()">Từ chối</button>
        @else
            <!-- <p>Đã hủy</p> -->
        @endif
    </div>
    
</div>
<script>
    let CTYCBH = @json($datayeucaubaohanhs);
</script>
<script src="{{ asset('js/jadeLight/detailsGuarentee.js') }}"></script>
<script src="{{ asset('js/library.message-box.js') }}"> </script>

@endsection


