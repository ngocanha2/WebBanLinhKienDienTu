@extends('layouts.layoutdashboard')
@section('content')
<?php
    
    
?>
    <div class="col-md-12" style="border-radius: 10px; margin-top: 30px; background-color: white; min-height: 700px">
        <div class="row">
        <h2 style="column-span:3; text-align: center; margin-top: 25px; color: brown"><b>THÔNG TIN NHÂN VIÊN</b></h2>
        
        <div class="col-md-12">
            <a href="http://127.0.0.1:8000/insert-employee"><button class="btn btn-warning" style="width: 300px; margin-left: 20px;">Thêm nhân viên</button></a>
            <p style="margin-left: 20px; margin-top: 10px;"><b>Chức vụ:</b> {{ $chucvu }}</p>
            <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px; align-content:center;text-align:center;justify-content:center;align-items:center; width: 98%; margin-left: 10px;">
                <thead>
                    <tr>
                        <th>Mã nhân viên</th>
                        <th>Tên nhân viên</th>
                        <th>Tên đăng nhập</th>
                        <th>Mật khẩu</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                        <th>SĐT</th>
                        <th>Địa chỉ</th>
                        <th>Chức vụ</th>
                        <th>Thao tác</th>

                    </tr>
                    @foreach ($nhanviens as $nv) 
                    <tr>
                        <td style="text-align: center">{{$nv->MaNV }}</td>
                        <td style="text-align: center">{{$nv->TenNV }}</td>
                        <td style="text-align: center">{{$nv->TenDangNhap }}</td>
                        <td style="text-align: center">***</td>
                        <td style="text-align: center">{{$nv->NgaySinh }}</td>
                        <td style="text-align: center">{{$nv->GioiTinh }}</td>
                        <td style="text-align: center">{{$nv->SDTNV }}</td>
                        <td style="text-align: center">{{$nv->DiaChi }}</td>
                        <td style="text-align: center">{{$nv->ChucVu }}</td> 
                         
                
                        <td>
                            @if($chucvu == "Quản lý")
                                <a href="{{ route('detail-employee', ['id'=>$nv->MaNV])}}"><button class="btn btn-primary" style="margin-top: 5px; width: 100px;">Sửa</button></a>
                                <a href="{{ route('employee-resetPassword', ['id'=>$nv->MaNV])}}"><button class="btn btn-outline-danger" style="margin-top: 5px; width: 100px;">Đặt lại mật khẩu</button></a>  

                            @endif
                        </td>
                    </tr>
                    @endforeach
                </thead>
            </table>
        </div>
        </div>
    </div>

@endsection