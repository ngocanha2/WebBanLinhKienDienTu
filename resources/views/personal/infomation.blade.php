@extends('layouts.layoutpersonal')
@section('content')

<div class="header">
    <div class="left">
        <h1>Thông tin cá nhân</h1>
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
        <div class="box-white box-info">
            {{-- <div class="information-title">Profile</div>  --}}                                                           
            <div class="row p-0">
                <div class="col-lg-6">
                    <div class="box-information-input">
                        <label for="input-username" class="information-label">Tên đăng nhập</label>
                        <input id="input-username" class="information-input readonly" name="TenDangNhap" type="text" placeholder="Tên đăng nhập">
                        <span class="error-information" id="error-input-username"></span>
                    </div>   
                    <div class="box-information-input">
                        <label for="input-full-name" class="information-label">Họ và tên</label>
                        <input id="input-full-name" class="information-input readonly" type="text" name="HoVaTen" placeholder="Họ và tên">
                        <span class="error-information" id="error-input-full-name"></span>
                    </div>                              
                    <div class="box-information-input">
                        <label for="input-email" class="information-label">Email</label>
                        <input id="input-email" class="information-input readonly" type="Email" name="Email" placeholder="email@vidu.com">
                        <span class="error-information" id="error-input-email"></span>
                    </div> 
                    <div class="box-information-input">
                        <label for="input-phone-number" class="information-label">Số điện thoại</label>
                        <input id="input-phone-number" maxlength="10" class="information-input readonly" type="text" name="SDT" placeholder="Số điện thoại" maxlength="10">
                        <span class="error-information" id="error-input-phone-number"></span>
                    </div>                                    
                </div>
                <div class="col-lg-6">
                    <div class="box-information-input">
                        <label for="input-date-of-birth" class="information-label">Ngày sinh</label>
                        <input id="input-date-of-birth" class="information-input" type="date" name="NgaySinh" placeholder="dd/MM/yyyy">
                        <span class="error-information" id="error-input-date-of-birth"></span>
                    </div> 
                    <div class="box-information-input">
                        <label class="information-label">Giới tính</label>
                        <div class="information-input ">
                            <div class="item-gender">
                                <input type="radio" value="Nam" id="radio-gender-male" name="GioiTinh" disabled>
                                <label for="radio-gender-male">Nam</label> 
                            </div> 
                            <div class="item-gender">
                                <input type="radio" value="Nữ" id="radio-gender-female" name="GioiTinh" disabled>     
                                <label for="radio-gender-female">Nữ</label>                             
                            </div>                                                                                                                                                                
                        </div>
                        <span class="error-information" id="error-input-gender"></span>
                    </div>                     
                    <div class="box-information-input">
                        <label class="information-label">Mật khẩu</label>
                        <div class="information-input information-input-don-hover">
                            <div id="input-password"></div>
                            <button class="btn-update-password" data-bs-toggle="modal" data-bs-target="#modal-change-password">Đổi mật khẩu</button>
                        </div>                            
                    </div>
                    <div class="box-information-input">
                        <label class="information-label">Ngày tham gia</label>
                        <div id="input-joining-date" class="information-input information-input-don-hover">24/04/2023</div>
                    </div> 
                </div>
                <div class="box-button">
                    <input type="checkbox" name="update-data" id="update-data-information" hidden>
                    <label class="btn-update btn btn-outline-dark" for="update-data-information">Sửa</label>                    
                </div>
            </div>                                              
                                                                                            
        </div>
    </div>
    <div class="modal fade" id="modal-change-password" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <center>Đổi mật khẩu</center>
              <button type="button" class="btn-close" id="btn-modal-change-password-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="post" id="form-change-password">
                <div class="modal-body" style="height: 350px;">
                    <div class="box-information-input">
                        <label for="input-old-password" class="information-label">Mật khẩu cũ</label>
                        <input id="input-old-password" maxlength="10" class="information-input password" type="password" name="old_password" placeholder="Mật khẩu cũ" >
                        <span class="error-information" id="error-input-old-password"></span>
                    </div> 
                    <div class="box-information-input">
                        <label for="input-new-password" class="information-label">Mật khẩu mới</label>
                        <input id="input-new-password" maxlength="10" class="information-input password" type="password" name="new_password" placeholder="Mật khẩu mới">
                        <span class="error-information" id="error-input-new-password"></span>
                    </div> 
                    <div class="box-information-input">
                        <label for="input-new-password-confirmation" class="information-label">Nhập lại mật khẩu mới</label>
                        <input id="input-new-password-confirmation" maxlength="10" class="information-input password" type="password" name="new_password_confirmation" placeholder="Nhập lại mật khẩu mới" >
                        <span class="error-information" id="error-input-new-password-confirmation"></span>
                    </div> 
                    <div class="box-show-password">
                        <input type="checkbox" id="show-password">
                        <label for="show-password">Hiện mật khẩu</label>
                    </div>
                </div>
                <div class="modal-footer">   
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-warning">Lưu</button>               
                </div>
            </form>
          </div>
        </div>
      </div>
    
    <script src="{{asset("js/callapi/personal/information.js")}}"></script>
    <script src="{{asset("js/handle/personal/information.js")}}"></script>
    

@endsection