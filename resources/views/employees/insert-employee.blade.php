@extends('layouts.layoutdashboard')
@section('content')
<head>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>
</head>
    <div class="col-md-12" style=" border-radius: 10px; margin-top: 30px; background-color: white; min-height: 700px;">
        
        <h2 style="column-span:3; text-align: center; margin-top: 25px; color: brown; padding: 20px;"><b>THÊM THÔNG TIN NHÂN VIÊN</b></h2>
        <form method="GET" action="{{route('insert')}}" id="form-employee">
            <div class="row">
            <div class="col-md-5" style="margin-left: 100px;">
                <p>Tên nhân viên<input class="form-control" type="text"  name="txt_TenNV" id="tenNV" ></p>
                <p>Tên đăng nhập<input class="form-control" type="text"  name="txt_TenDangNhap" id="tenDN"></p>
                <p>Mật khẩu<input class="form-control" type="text"  name="txt_MatKhau" id="matKhau"></p>
                
                <p>Địa chỉ<textarea class="form-control" name="txt_DiaChi" id="diaChi" style="height: 100px;"></textarea></p>
            </div>
            <div class="col-md-5">
                <p>Ngày sinh<input type="text" id="ngaySinh" name="txt_NgaySinh" class="form-control" placeholder="Chọn ngày sinh" ></p>
                <p>Giới tính
                    <select class="form-control" name="cbo_GioiTinh">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                    </select>
                </p>
                <p>SDT<input class="form-control" type="text"  name="txt_SDT" id="sdt" maxlength="10"></p>
                <p>Chức vụ
                    <select class="form-control" name="cbo_ChucVu">
                            <option value="Nhân viên">Nhân viên</option>
                            <option value="Quản lý">Quản lý</option>
                    </select>
                </p>
                <a href="{{route('insert')}}"><button class="btn btn-danger" style="width: 100px;">Lưu</button></a>
            </div>
            </div>
        </form>
        
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