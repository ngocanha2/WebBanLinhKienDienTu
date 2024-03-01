@extends('layouts.layoutdashboard')
@section('content')
<link href="{{ asset('css/library/tab.css') }}" rel="stylesheet">
<style>
  .td-center{
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
  .btn-destroy
  {
    margin: 4 0;
    width: 110px;
  }
</style>
    <div class="container">
      <div class="header">
        <div class="left">
            <h1>Danh mục</h1>
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
        <button class="report" id="btn-add-category" data-bs-toggle="modal" data-bs-target="#modal-edit-category">
            <i class='bx bx-add-to-queue' ></i>
            <span>Thêm danh mục</span>
        </button>
    </div>
      {{-- <button class="btn btn-outline-primary" id="" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">Thêm khuyễn mãi</button>          --}}
        <div class="card">            
            <div class="card-body">           
        
              <div class="tab-content" style="min-height: 600px;">
                <div class="tab-pane active box-my-short-links" id="status-0">
                    <table class="table table-hover table-striped table-bordered" border="1">
                        <tr>
                            <th>Mã danh mục</th>
                            <th>Tên danh mục</th>
                            <th></th>
                        </tr>
                        <tbody id="tbody-category"></tbody>
                    </table>
                    </div>                                    
                </div>
              <div style="padding: 20px;"> <ul class="pagination" id="pagination" style="clear: both"></div>
            </div>
        </div>  
        <ul class="pagination" id="pagination"></ul>      
    </div>

    <div class="modal fade" id="modal-edit-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <center style="font-size: 20px;">Cập nhật thông tin danh mục</center>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="" method="POST" id="form-edit-promotion">
              <div class="modal-body">                                                
                  <div class="p-lg-4 row" >
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="MaDanhMuc">Mã danh mục</label>
                          <input class="input-update" type="text" name="MaDanhMuc" disabled id="MaDanhMuc" placeholder="Mã danh mục">
                          <span class="error-validate-update MaDanhMuc"></span>
                      </div>
                    </div>
                    <div class="col-lg-6 col-12">
                      <div class="box-input-update">
                          <label class="label-input-update" for="TenDanhMuc">Tên danh mục<span class="required-field">*</span></label>
                          <input class="input-update" type="text" name="TenDanhMuc" id="TenDanhMuc" required placeholder="Tên danh mục">
                          <span class="error-validate-update TenDanhMuc"></span>
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
    <script src="{{asset("js/handle/manager/category/category.index.js")}}"></script>
@endsection