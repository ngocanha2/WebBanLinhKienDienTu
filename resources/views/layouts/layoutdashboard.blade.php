@extends('layouts.layout_setup')
@php   
    // $user->Auth::guard("admin-api")->user();
@endphp
@section('menu')
    <ul class="side-menu p-0">           
        <li><a class="bg-warning btn-create-short-link" data-bs-toggle="modal" data-bs-target="#modal-create-short-link"> <i class='bx bx-mail-send'></i>Gửi Mail</a></li>                
        {{-- @foreach ($user->getRouteInterfaces() as $route)                   
            <li title="{{$route->interface_name}}" class="{{request()->is(str_replace(url('/')."/", '', route("web.".$route->route_name))) ? 'active' :'' }} "><a href="{{route("web.".$route->route_name)}}"><i class='bx {{$route->icon}}'></i>{{$route->interface_name}}</a></li>
        @endforeach             --}}
        {{-- <li class="{{request()->is('manager/dashboard') ? 'active' :'' }} "><a href="{{route("web.manager-dashboard")}}"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
        <li class="{{request()->is('manager/links/index') ? 'active' :'' }} "><a href="{{route("web.manager-links-index")}}"><i class='bx bx-link-alt' ></i></i>Links</a></li>  
        <li class="{{request()->is('personal/links/index') ? 'active' :'' }} "><a href="{{route("web.personal-links-index")}}"><i class='bx bx-link' ></i></i>My links</a></li>                                                                                         
        <li class="{{request()->is('manager/user') ? 'active' :'' }} "><a href="{{route("web.manager-users-index")}}"><i class='bx bx-group'></i>Users</a></li>        --}}    
        <li class="{{request()->is('statistical-search') ? 'active' :'' }} "><a href="{{route("statistical")}}"><i class='bx bx-line-chart'></i>Thông kê</a></li>
        <li class="{{request()->is('productstore') ? 'active' :'' }} " id="menu-item-product"><a href="{{route("productstore")}}"><i class='bx bx-archive'></i>Sản phẩm</a></li>
        <li class="{{request()->is('orderstore') ? 'active' :'' }} " id="menu-item-order"><a href="{{route("orderstore")}}"><i class='bx bx-package'></i>Đơn hàng</a></li> 
        <li class="{{request()->is('admin/guarantee') ? 'active' :'' }} " id="menu-item-order"><a href="/admin/guarantee"><i class='bx bx-wrench'></i>Bảo hành - sửa chữa</a></li> 
        <li class="{{request()->is('manager/promotion') ? 'active' :'' }} "><a href="{{route("manager.promotion.index")}}"><i class='bx bxs-offer' ></i>Khuyến mãi</a></li>
        <li class="{{request()->is('manager/supply-order') ? 'active' :'' }} " id="menu-item-supply-order"><a href="/manager/supply-order"><i class='bx bx-basket' ></i>Đặt hàng</a></li>
        <li class="{{request()->is('manager/delivery') ? 'active' :'' }} "><a href="/manager/delivery"><i class='bx bx-archive-in'></i>Giao hàng</a></li>
        <li class="{{request()->is('manager/supplier') ? 'active' :'' }} "><a href="/manager/supplier"><i class='bx bx-food-menu'></i>Nhà cung cấp</a></li>
        <li class="{{request()->is('manager/supplier/provide') ? 'active' :'' }} "><a href="/manager/supplier/provide"><i class='bx bx-cart-download'></i>Nguồn cung</a></li> 
        <li class="{{request()->is('manager/category') ? 'active' :'' }} "><a href="/manager/category"><i class='bx bx-category-alt'></i>Danh mục</a></li> 
        <li class="{{request()->is('manager/user') ? 'active' :'' }} " id="menu-item-user"><a href="/manager/user"><i class='bx bx-group'></i>Khách hàng</a></li> 
        <li class="{{request()->is('employee') ? 'active' :'' }} "><a href="{{route("manager.employee")}}"><i class='bx bx-git-merge'></i>Nhân viên</a></li>
        <li class="{{request()->is('information-employee') ? 'active' :'' }} " id="menu-item-account"><a href="{{route("information-employee")}}"><i class='bx bxs-user-account' ></i>Tài khoản</a></li> 
                                   
    </ul>
@endsection

@section('content-main')
    @yield('content')
@endsection

@section('mail')
<style>
    textarea.input-update{
        padding-top: 10px;
        min-height: 300px; 
        max-height: 500px;
    }
</style>
<div class="modal fade" id="modal-create-short-link" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <center>Gửi Mail</center>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="form-send-mass-mail">
            <div class="modal-body" style="min-height: 500px;">                            
                <div class="p-lg-4 row" >
                    <div class="col-12">
                        <div class="box-input-update">
                            <label class="label-input-update" for="TieuDe">Tiêu đề<span class="required-field">*</span></label>
                            <input class="input-update" type="text" style="color: black" name="TieuDeMail" id="TieuDe" placeholder="Tiêu đề">
                            <span class="error-validate-update TieuDe"></span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="box-input-update">
                            <label class="label-input-update" for="NoiDung">Nội dung<span class="required-field">*</span></label>
                            <textarea class="input-update" name="NoiDungMail" id="NoiDung" placeholder="Nội dung"></textarea>
                            <span class="error-validate-update NoiDung"></span>
                        </div>
                    </div>
                    <div class="col-12 p-lg-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="HangLoat" value="true" id="checkbox-mass-mail" checked>
                            <label class="form-check-label" for="checkbox-mass-mail">Gửi hàng loạt</label>
                        </div>
                    </div>
                    <br><br>
                    <br>
                    <div class="col-12" id="box-mail-address" style="display: none">
                        <div class="box-input-update">
                            <label class="label-input-update" for="DiaChi">Địa chỉ mail cụ thể (các mail ngăn cách nhau bởi khoảng trắng)<span class="required-field">*</span></label>
                            <input class="input-update" name="DiaChiMail" id="DiaChi" placeholder="vidu1@email.com,vidu2@email.com" type="text">
                            <span class="error-validate-update DiaChi"></span>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="modal-footer">      
                <a type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</a>
                <button type="submit" class="btn btn-primary btn-save" id="btn-save">Gửi</button>            
            </div>
        </form>
      </div>
    </div>
  </div>
  <script src="{{asset('js/handle/manager/mail/mass.mail.js')}}"></script>
@endsection