@extends('layouts.layoutdashboard')
@section('content')
<style>
    .input-update-price{
        height: 40px;
        width: 150px;
        text-align: center;
        font-size: 17px;
        border: 1px solid #aaaaaa;
        border-radius: 5px;        
    }
    .btn-update-price{
        margin-top:5px 
    }
</style>
    <div class="container">
      <div class="header">
        <div class="left">
            <h1>Nguồn cung hàng hóa</h1>
            <ul class="breadcrumb">
                {{-- <li><a href="#">
                        Analytics
                    </a></li>
                /
                <li><a href="#" class="active">Shop</a></li> --}}
            </ul>
        </div>    
    </div>
      {{-- <button class="btn btn-outline-primary" id="" data-bs-toggle="modal" data-bs-target="#modal-edit-promotion">Thêm khuyễn mãi</button>          --}}
        <div class="row">
            <div class="box-information-input col-xl-4 col-md-6">            
                <label for="supplier-id" class="information-label">Nhà cung cấp</label>
                <select id="supplier-id" class="information-input readonly text-left" name="MaNCC">                
                </select>            
            </div> 
            <div class="box-information-input col-xl-3 col-md-6">            
                <label for="product-id" class="information-label">Hàng hóa chưa cung cấp</label>
                <select id="product-id" class="information-input text-left disabled"  name="MaHang">                
                </select>            
            </div> 
            <div class="box-information-input col-xl-3 col-md-6">            
                <label for="GiaNhap" class="information-label">Giá nhập</label>
                <input type="number" name="GiaNhap" class="information-input text-left" id="GiaNhap" placeholder="Giá nhập">           
            </div>
            <div class="col-xl-2 col-md-6">
                <br>
                <button class="btn btn-info" id="btn-add">Thêm nguồn cung</button>
            </div>
        </div>
        <div class="box-white p-lg-4">
            <div id="box-body">            
            </div>        
            <ul class="pagination" id="pagination"></ul> 
        </div>             
    </div>
    <script src="{{asset("js/handle/manager/supplier/supplier.provide.js")}}"></script>
@endsection