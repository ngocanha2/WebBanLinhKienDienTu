@extends('layouts.layoutdashboard')
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
</head>
<style>
    .box-info{
        min-height: 600px;
        padding: 20px;
        position: relative;
    }
    .box-information-input{
        position: relative;
        padding: 20px 10px;
    }
    .information-label{
        position: absolute;
        background: var(--bs-body-bg);
        top: 7;
        left: 20px;
        padding: 0 5;   
        cursor: pointer; 
        border-radius: 5px; 
    }
    .information-input{
        width: 100%;
        text-align: center;
        height: 45px;
        border-radius:5px;
        border: 1px solid black; 
        cursor: default;   
        background-color: var(--bs-body-bg); 
    }
    .error-information{
        font-size: 13px;
        color: red;
        position: absolute;
        bottom: 0;
        left: 11;
        display: none;
    }
    .information-input.error-information-input{
        border: 1px solid red;
    }
    input.information-input-hover:hover{
        border: 1px solid #f7b500;
        cursor: auto;     
    }
    .information-input:focus{
        border: 1px solid #f7b500;     
    }
    div.information-input{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10%;
    }
    .information-input.information-input-don-hover:hover{
        border: 1px solid black; 
    }
    .item-gender{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3px;
    }
    .box-image-avatar{
        position: relative;
    }
    .image-avatar{    
        display: block;
        width: 100%;
        height: 300px;
        border-left:1px solid var(--bs-light-text-emphasis);   
        border-right:1px solid var(--bs-light-text-emphasis);  
        border-top:1px solid var(--bs-light-text-emphasis);   
    }
    .information-title{
        color:#f7b500;
        background-color: black;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 10px;
        font-size: 17px;
    }
    #input-joining-date{
        cursor: default;
    }
    .box-account-link{
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;    
    }
    .box-button{
        padding: 20px 30px;
        position: absolute;
        bottom: 0;
    }
    .btn-update{
        float: right;
        width: 110px;
    }
    .box-btn-choose-avatar{
        position: relative;
        display: flex;
        justify-content: center;
        cursor: pointer;
    }
    .btn-update-avatar{
        width: 100%;
        font-size:17px;
        background-color: #f7cf62;
        color: black;
        border-bottom-left-radius: 5px;  
        border-bottom-right-radius: 5px;  
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        border-top:none;
        padding: 5px 10px;
    }
    .information-input-hover:hover{
        border: 1px solid #f7b500;     
    }
    .box-drop-drag-avatar{
        width: 100%;
        border: 3px dashed #f7b500;
        border-radius: 10px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        overflow: hidden;
        position: relative;
    }
    .title-choose-avatar{
        width: 100%;
        text-align: center;
        color: var(--bs-light-text-emphasis);   
    }
    #btn-choose-avatar{
        padding: 5px 10px;
        width: 100px;
        border-radius: 5px;
        background-color: #f7b500;    
    }
    .box-operation-choose-avatar{
        margin: 10 0;
        min-height: 70px;
    }
    .box-show-avatar{    
        top: 0;    
        min-width:100%; 
        height: 100%;          
    }
    .avatar-preview{
        border-top-left-radius:5px; 
        border-top-right-radius:5px; 
        height: 100%;    
    }
    .box-image-avatar{
        border-right: 1px solid #000; 
        border-bottom: 1px solid #000;  
        border-left: 1px solid #000;  
        margin-left:12px;  
        border-bottom-left-radius: 5px;      
        border-bottom-right-radius: 5px;      
    }
    .item-image-avatar{        
        padding-top:10px; 
        padding-bottom:10px;
        color: crimson; 
    }
    .item-remove-avatar{
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        opacity: 0;
    }
    .image-avatar:hover .item-remove-avatar{
        opacity: 1;
    }
    @media (max-width:991px){ 
        .box-button{
            position: sticky;
            width: 100%;     
            bottom: 0px;        
        }   
        .btn-update{
            background-color: var(--bs-light-text-emphasis);
        }
    }
    @media (max-width:767px){
        .item-image-avatar{
            padding: 0;
        }
        .box-image-avatar{
            border: none;
            margin:0;
        }
        .item-remove-avatar{
            right: 12px;
            top: 1px;
        }    
    }
    .btn-update-password{
            position: absolute;
            right: 10;
            border-right: none;
            border: 1px solid var(--bs-light-text-emphasis);
            border-radius:5px; 
            background-color: var(--bs-light);
            opacity: 0;
            transition: all 0.3s;
            height: 45px;
        }
    .information-input:hover .btn-update-password{
        opacity: 1;      
        width: auto;
    }
    .btn-update-password:hover{
        border: 1px solid #f7b500;
    }
    .border-message{
            border: 1px solid red;        
        }
    .box-show-password{
        margin-left: 10px;
    }
</style>
<div class="header">
    <div class="left">
        <h1>THÔNG TIN CÁ NHÂN</h1>
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
    {{-- <button class="report">
        <i class='bx bx-check-double' ></i>
        <span>Save</span>
    </button> --}}
</div>
    <div class="container">
        <div class="col-md-12" style=" border-radius: 10px; margin-top: 30px; background-color: white;">
        <div class="box-white box-info">
            @foreach ($nhanvieninfo as $nv)
            <form method="GET" id="form-information" action="{{ route('update-information', ['id'=>3]) }}">                 
            <div class="row p-0">
                <div class="col-lg-6">
                    <div class="box-information-input">
                        <label for="input-username" class="information-label">Tên đầy đủ</label>
                        <input id="tenNV"class="information-input readonly" name="txt_TenNV" type="text" placeholder="Fullname" value="{{ $nv->TenNV }}">
                        
                    </div>   
                    <div class="box-information-input">
                        <label for="input-full-name" class="information-label">Tên đăng nhập</label>
                        <input id="tenDN" class="information-input readonly" type="text" name="txt_TenDangNhap" placeholder="UserName" value="{{ $nv->TenDangNhap }}" readonly>
                        
                    </div>                              
                    <div class="box-information-input">
                        <label class="information-label">Mật khẩu</label>
                        <input id="matKhau" class="information-input readonly" type="password" name="txt_MatKhau" placeholder="Password" value="{{ $nv->password }}" readonly>
                    </div>                                    
                </div>
                <div class="col-lg-6">
                    <div class="box-information-input">
                        <label class="information-label">Số điện thoại</label>
                        <input id="sdt" class="information-input readonly" type="text" name="txt_SDT" placeholder="Phone number" maxlength="10" value="{{ $nv->SDTNV }}">
                        
                    </div> 
                    <div class="box-information-input">
                        <label class="information-label">Ngày sinh</label>
                        <input id="ngaySinh" class="information-input readonly" type="text" name="txt_NgaySinh" placeholder="Date Birthday" value="{{ $nv->NgaySinh }}">
                    </div>
                    <div class="box-information-input">
                        <label class="information-label">Giới tính</label>
                        <input id="gioiTinh" class="information-input readonly" type="text" name="txt_GioiTinh" placeholder="Gender" value="{{ $nv->GioiTinh }}">
                    </div> 
                    <div class="box-information-input">
                        <label class="information-label">Địa chỉ</label>
                        <input id="diaChi" class="information-input readonly" type="text" name="txt_DiaChi" placeholder="Address" value="{{ $nv->DiaChi }}">
                    </div> 
                </div>
                <div style="margin-top: 50px;">
                    <a href="{{ route('update-information', ['id'=>3]) }}"><button class="btn btn-warning" name="btn_ThayDoi" style="width: 200px;">Thay đổi thông tin<button></a>
                    
                </div>
            </div>                                             
        </form> 
        <a href="http://127.0.0.1:8000/change-password"><p style="margin-left: 50px;">Đổi mật khẩu</p></a>                
        @endforeach                                                                     
        </div>
        </div>
        @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    </div>  
    <script>
        $(document).ready(function(){
            $("#ngaySinh").datepicker({
                format: "yyyy-mm-dd", 
                language: "vi",
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
        <script src="{{ asset('js/doman/employee.js') }}"></script>
@endsection