@extends('layouts.layoutdashboard')
@section('content')
<style>
  .td-center{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  .btn-delete{
    margin: 4;
    width: 110px;
  }
</style>
<link href="{{ asset('css/library/tab.css') }}" rel="stylesheet">
    <div class="container">
      <div class="header">
        <div class="left">
            <h1>Khuyến mãi</h1>
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
        <button class="report" id="btn-add-promotion" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">
            <i class='bx bx-add-to-queue' ></i>
            <span>Thêm khuyến mãi</span>
        </button>
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
                    <span class="icon"><i class='bx bx-dice-2' ></i></span>
                    <span class="text">Đang diễn ra</span>
                  </a>
                </li>
                <li>
                  <a  class="tab" data-id="status-2">
                    <span class="icon"><i class='bx bx-dice-3' ></i></span>
                    <span class="text">Sắp diễn ra</span>
                  </a>
                </li>
                <li>
                    <a  class="tab" data-id="status-3">
                      <span class="icon"><i class='bx bx-dice-4' ></i></span>
                      <span class="text">Đã kết thúc</span>
                    </a>
                </li>                     
              </ul>
        
              <div class="tab-content" style="min-height: 600px;">
                <div class="tab-pane active box-my-short-links" id="status-0">
                    {{-- <table class="table table-hover table-striped table-bordered" border="1">
                        <tr>
                            <th>Mã khuyến mãi</th>
                            <th>Tỷ lệ giảm giá</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                        </tr>
                        <tbody></tbody>
                    </table>             --}}
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

    <div class="modal fade" id="modal-edit-promotion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <center style="font-size: 20px;">Cập nhật thông tin khuyễn mãi</center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="POST" id="form-edit-promotion">
              <div class="modal-body">                  
                              
                  <div class="p-lg-4 row" >
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="TenKhuyenMai">Tên khuyễn mãi</label>
                          <input class="input-update" type="text" name="TenKhuyenMai" id="TenKhuyenMai" placeholder="Tên khuyến mãi">
                          <span class="error-validate-update TenKhuyenMai"></span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="TyLeGiamGia">Tỷ lệ giảm giá<span class="required-field">*</span></label>
                          <input class="input-update" type="text" name="TyLeGiamGia" id="TyLeGiamGia" placeholder="Tỷ lệ giảm giá">
                          <span class="error-validate-update TyLeGiamGia"></span>
                      </div>
                    </div>  
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="NgayBatDau">Ngày bắt đầu<span class="required-field">*</span></label>
                          <input class="input-update" type="date" name="NgayBatDau" id="NgayBatDau" placeholder="Ngày bắt đầu">
                          <span class="error-validate-update NgayBatDau"></span>
                      </div>
                    </div>  
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="NgayKetThuc"
                          >Ngày kết thúc<span class="required-field">*</span></label>
                          <input class="input-update" type="date" name="NgayKetThuc" id="NgayKetThuc" placeholder="Ngày kết thúc">
                          <span class="error-validate-update NgayKetThuc"></span>
                      </div>
                    </div>      
                  </div>                    
              </div>
              <div class="modal-footer"> 
                  <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</a>
                  <button type="submit" class="btn btn-primary" id="btn-save-promotion">Lưu</button>                 
              </div>
          </form> 
        </div>
      </div>
  </div>       
    <script src="{{asset("js/library/tab.js")}}"></script>
    <script src="{{asset("js/handle/manager/promotion/promotion.index.js")}}"></script>
@endsection