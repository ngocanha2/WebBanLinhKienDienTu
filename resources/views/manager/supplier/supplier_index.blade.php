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
  .btn-delete
  {
    margin: 4 0;
    width: 110px;
  }
</style>
<link href="{{ asset('css/library/tab.css') }}" rel="stylesheet">
    <div class="container">
      <div class="header">
        <div class="left">
            <h1>Nhà cung cấp</h1>
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
        <button class="report" id="btn-add-supplier" data-bs-toggle="modal" data-bs-target="#modal-edit-supplier">
            <i class='bx bx-add-to-queue' ></i>
            <span>Thêm nhà cung cấp</span>
        </button>
    </div>
      {{-- <button class="btn btn-outline-primary" id="" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">Thêm khuyễn mãi</button>          --}}
        <div class="card">            
            <div class="card-body">                      
              <div class="tab-content" style="min-height: 600px;">
                <div class="tab-pane active box-my-short-links" id="status-0">
                    <table class="table table-hover table-striped table-bordered" border="1">
                        <tr>
                            <th>Mã nhà cung cấp</th>
                            <th>Tên nhà cung cấp</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>                            
                            <th></th>
                        </tr>
                        <tbody id="tbody-supplier"></tbody>
                    </table>
                </div>
                </div>
              <div style="padding: 20px;"> <ul class="pagination" id="pagination" style="clear: both"></div>
            </div>
        </div>  
        <ul class="pagination" id="pagination"></ul>      
    </div>

    <div class="modal fade" id="modal-edit-supplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <center style="font-size: 20px;">Cập nhật thông tin nhà cung cấp</center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="POST" id="form-edit-promotion">
              <div class="modal-body">                                                
                  <div class="p-lg-4 row" >
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="MaNCC">Mã nhà cung cấp</label>
                          <input class="input-update" type="text" name="MaNCC" disabled id="MaNCC" placeholder="Mã nhà cung cấp">
                          <span class="error-validate-update MaNCC"></span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="TenNCC">Tên nhà cung cấp<span class="required-field">*</span></label>
                          <input class="input-update" type="text" name="TenNCC" id="TenNCC" placeholder="Tên nhà cung cấp">
                          <span class="error-validate-update TenNCC"></span>
                      </div>
                    </div>  
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="DiaChi">Địa chỉ<span class="required-field">*</span></label>
                          <input class="input-update" type="text" name="DiaChi" id="DiaChi" placeholder="Địa chỉ">
                          <span class="error-validate-update DiaChi"></span>
                      </div>
                    </div>  
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="SDT">Số điện thoại<span class="required-field">*</span></label>
                          <input class="input-update" type="text" name="SDT" id="SDT" maxlength="10" placeholder="Số điện thoại">
                          <span class="error-validate-update SDT"></span>
                      </div>
                    </div>      
                  </div>                    
              </div>              
              <div class="modal-footer"> 
                  <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</a>
                  <button type="submit" class="btn btn-primary btn-save" id="btn-save">Lưu</button>                 
              </div>
          </form> 
        </div>
      </div>
  </div>       
    <script src="{{asset("js/library/tab.js")}}"></script>
    <script src="{{asset("js/handle/manager/supplier/supplier.index.js")}}"></script>
@endsection