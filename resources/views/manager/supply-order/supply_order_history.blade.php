

@extends('layouts.layoutdashboard')
{{-- @extends('layouts.app') --}}
@section('content')
<div class="container">
    <div class="header">
        <div class="left">
            <h1>Lịch sử đặt hàng</h1>
            <ul class="breadcrumb">
                {{-- <li><a href="#">
                        Analytics
                    </a></li>
                /
                <li><a href="#" class="active">Shop</a></li> --}}
            </ul>
        </div>
        {{-- <a href="#" class="report">
            <i class='bx bx-cloud-download'></i>
            <span>Download CSV</span>
        </a> --}}
        <a href="/admin/supply" class="report" id="btn-add-supplier">
            <i class='bx bx-add-to-queue' ></i>
            <span>Đặt hàng mới</span>
        </a>
    </div>
    <div class="box-white" style="padding:20px; background-color: white; ">

        <table class="table table-hover table-striped table-bordered" border="1">
            <tr>
                <th>Số phiếu đặt</th>
                <th>Nhà cung cấp</th>
                <th>Ngày đặt</th>
                <th>Tổng số lượng</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
            @foreach ($orders as $order)
            <tr>
                <td>{{$order->SoPhieuDatHang}}</td>                                
                <td>{{$order->MaNCC}} {{$order->TenNCC}}</td>                
                <td>{{$order->NgatDat}}</td>                
                <td>{{$order->TongSL}}</td>                
                <td>{{$order->ThanhTien}}</td>  
                <td>
                    <a class="btn btn-outline-info btn-show-details" sophieudathang="{{$order->SoPhieuDatHang}}">Xem</a>  
                    <a class="btn btn-info" href="/admin/detailsSupplyOrder/{{$order->SoPhieuDatHang}}" >Chi tiết</a>      

                </td>              
            </tr>
        @endforeach
        </table>

    </div>
  
</div>
<div class="modal fade" id="modal-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <center style="font-size: 20px;">Chi tiết đơn đặt hàng</center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>         
            <div class="modal-body" style="min-height: 600px;">                  
              <div class="row">
                  <div class="col-lg-12">                      
                      <table class="table table-hover table-striped table-bordered" border="1">
                          <tr>
                              <th>Số phiếu đặt</th>
                              <th>Hàng hóa</th>
                              <th>Số lượng đặt</th>
                              <th>Số lượng chưa giao</th>                                                                                                                             
                          </tr>
                          <tbody id="tbody-order-supplier">

                          </tbody>
                      </table>
                  </div>                  
              </div>                                                          
            </div>
            <div class="modal-footer"> 
                {{-- <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary" id="btn-save-promotion">Lưu</button>                  --}}
            </div>
      </div>
    </div>
</div> 
<script src="{{asset("js/handle/manager/supply-order/supply.order.history.js")}}"></script>
@endsection
