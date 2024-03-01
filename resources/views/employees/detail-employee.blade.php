@extends('layouts.layoutdashboard')
@section('content')
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
</head>
    <div class="col-md-12" style=" border-radius: 10px; margin-top: 30px; background-color: white;">
        
        <h2 style="column-span:3; text-align: center; margin-top: 25px; color: brown; padding: 20px;"><b>THÊM THÔNG TIN NHÂN VIÊN</b></h2>
        @foreach ($nhanvien as $nv)
        <form method="GET" id="form-employee" action="{{ route('update-employee', ['id'=>$nv->MaNV]) }}">
            <div class="row">  
                <div class="col-md-5" style="margin-left: 100px;">
                    <p>Tên nhân viên<input class="form-control" type="text"  name="txt_TenNV" id="tenNV" value="{{$nv->TenNV }}"></p>
                    <p>Tên đăng nhập<input class="form-control" type="text"  name="txt_TenDangNhap" id="tenDN" value="{{$nv->TenDangNhap }}"></p>
                    <p hidden>Mật khẩu<input class="form-control" type="password"  name="txt_MatKhau" id="matKhau" readonly value="{{$nv->MatKhau }}"></p>
                    
                    <p>Địa chỉ<textarea class="form-control" name="txt_DiaChi" id="diaChi" style="height: 100px;">{{$nv->DiaChi }}</textarea></p>
                </div>
                <div class="col-md-5">
                    <p>Ngày sinh<input type="text" id="ngaySinh" name="txt_NgaySinh" class="form-control" placeholder="Chọn ngày sinh" value="{{$nv->NgaySinh }}" ></p>
                    <p>Giới tính
                        <select class="form-control" name="cbo_GioiTinh">
                            <option value="{{$nv->GioiTinh }}">{{$nv->GioiTinh }}</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                    </select>
                    </p>
                    <p>SDT<input class="form-control" type="text"  name="txt_SDT" id="sdt" value="{{$nv->SDTNV }}" maxlength="10"></p>
                    <p>Chức vụ
                        <select class="form-control" name="cbo_ChucVu">
                                <option value="{{$nv->ChucVu }}">{{$nv->ChucVu }}</option>
                                <option value="Quản lý">Quản lý</option>
                                <option value="Nhân viên">Nhân viên</option>
                        </select>
                    </p>
                    
                </div>
            </div>
            <br>
            <br>
            <br>
            <center><a href="{{ route('update-employee', ['id'=>$nv->MaNV]) }}"><button class="btn btn-danger" style="width: 100px;">Lưu</button></a></center>
            <br>
        </form>
    </div>
                @endforeach
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