@extends('layouts.layoutdashboard')
@section('content')
<link href="{{ asset('css/library/tab.css') }}" rel="stylesheet">
<style>
  .btn-cancel,
  .btn-details{
    width: 95px;
    margin: 4 0;
  }
</style>
    <div class="container">
      <div class="header">
        <div class="left">
            <h1>Giao hàng</h1>
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
        <a href="/admin/supply" class="report">
            <i class='bx bx-add-to-queue' ></i>
            <span>Đặt thêm hàng</span>
        </a>
    </div>
    <div>                            
        <div class="box-information-input col-lg-4 col-md-6">            
            <label for="supplier-id" class="information-label">Nhà cung cấp</label>
            <select id="supplier-id" class="information-input readonly text-left" name="MaNCC">                
            </select>            
        </div>    
    </div>
      {{-- <button class="btn btn-outline-primary" id="" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">Thêm khuyễn mãi</button>          --}}
        <div class="card">            
            <div class="card-body">
              <ul class="navbar">
                <li>
                    <a  class="tab active" data-id="status-0">
                      <span class="icon"><i class='bx bx-home-alt-2' ></i></span>
                      <span class="text">Tất cả</span>
                    </a>
                </li>
                <li>
                  <a  class="tab" data-id="status-1">
                    <span class="icon"><i class='bx bx-home-alt-2' ></i></span>
                    <span class="text">Chờ xác nhận</span>
                  </a>
                </li>
                <li>
                  <a  class="tab" data-id="status-2">
                    <span class="icon"><i class='bx bx-dice-2' ></i></span>
                    <span class="text">Đã xác nhận</span>
                  </a>
                </li>
                <li>
                  <a  class="tab" data-id="status-3">
                    <span class="icon"><i class='bx bx-dice-3' ></i></span>
                    <span class="text">Từ chối</span>
                  </a>
                </li>                                   
              </ul>
        
              <div class="tab-content" style="min-height: 600px;">
                <div class="tab-pane active box-my-short-links" id="status-0">                                       
                    </div>
                    <div class="tab-pane box-my-short-links" id="status-1">           
                    </div>
                    <div class="tab-pane box-my-short-links" id="status-2">            
                    </div> 
                    <div class="tab-pane box-my-short-links" id="status-3">            
                    </div>  
                </div>
              <div style="padding: 20px;"> <ul class="pagination" id="pagination" style="clear: both"></div>
            </div>
        </div>  
        <ul class="pagination " id="pagination"></ul>      
    </div>



    
    <div class="modal fade" id="modal-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog  modal-xl">
        <div class="modal-content">
          <div class="modal-header">
            <center style="font-size: 20px;">Chi tiết</center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>         
              <div class="modal-body" style="min-height: 600px;">                  
                <div class="row">
                    <div class="col-lg-6">
                        <center>Chi tiết đơn đặt (Không tính chưa xác nhận)</center>
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
                    <div class="col-lg-6">
                        <center>Chi tiết đơn giao</center>
                        <table class="table table-hover table-striped table-bordered" border="1">
                            <tr>
                                <th>Số phiếu giao</th>
                                <th>Hàng hóa</th>
                                <th>Số lượng</th>                                                                                              
                            </tr>
                            <tbody id="tbody-delivery">

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
    <script src="{{asset("js/library/tab.js")}}"></script>
    <script src="{{asset("js/handle/manager/delivery/delivery.index.js")}}"></script>
@endsection