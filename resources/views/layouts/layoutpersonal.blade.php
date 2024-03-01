@extends('layouts.layout_setup')
@php
    $user = Auth::user()    
@endphp
@section('menu')
    <ul class="side-menu p-0">           
        {{-- <li><a class="bg-warning btn-create-short-link" data-bs-toggle="modal" data-bs-target="#modal-create-short-link"> <i class='bx bx-add-to-queue'></i> Create link</a></li>                 --}}
        {{-- @foreach ($user->getRouteInterfaces() as $route)                   
            <li title="{{$route->interface_name}}" class="{{request()->is(str_replace(url('/')."/", '', route("web.".$route->route_name))) ? 'active' :'' }} "><a href="{{route("web.".$route->route_name)}}"><i class='bx {{$route->icon}}'></i>{{$route->interface_name}}</a></li>
        @endforeach             --}}
        {{-- <li class="{{request()->is('manager/dashboard') ? 'active' :'' }} "><a href="{{route("web.manager-dashboard")}}"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
        <li class="{{request()->is('manager/links/index') ? 'active' :'' }} "><a href="{{route("web.manager-links-index")}}"><i class='bx bx-link-alt' ></i></i>Links</a></li>  
        <li class="{{request()->is('personal/links/index') ? 'active' :'' }} "><a href="{{route("web.personal-links-index")}}"><i class='bx bx-link' ></i></i>My links</a></li>                                                                                         
        <li class="{{request()->is('manager/user') ? 'active' :'' }} "><a href="{{route("web.manager-users-index")}}"><i class='bx bx-group'></i>Users</a></li>        --}}    
        <li class="{{request()->is('personal/address') ? 'active' :'' }} "><a href="{{route("personal-address")}}"><i class='bx bxs-edit-location' ></i>Sổ địa chỉ</a></li>
        <li class="{{request()->is('personal/order') ? 'active' :'' }} " id="menu-item-order"><a href="{{route("personal-order")}}"><i class='bx bx-package'></i>Đơn hàng</a></li>                            
        <li class="{{request()->is('personal/infomation') ? 'active' :'' }} "><a href="{{route("personal-infomation")}}"><i class='bx bx-cog'></i>Tài khoản</a></li>                            
    </ul>
@endsection

@section('content-main')
    @if(!$user->isVerify())
    <script src="{{asset("js/callapi/auth/verify_email.js")}}"></script>
        <style>
            .box-message-confim-email{                        
                border: 1px solid #006488;
                border-radius: 5px;
                margin-bottom: 20px;
                background-color: var(--light);
            }
            .title-message-confim-email{
                color: var(--primary);
                font-size: 17px;
            }
            .box-close-mes{
            display: flex;
            justify-content: center;
            align-items: center;
            }
            .box-message-confim-email-title,
            .icon-close{
            padding: 20px;
            border:none;
            border-radius: 10px;                    
            }
            .title-message-confim-email:hover{
                color: #006488;
            }
            .btn-re-send-verify-email:hover{
                color: var(--primary);
            }
        </style>
        <script src="{{asset("js/handle/auth/verify_email.js")}}"></script>
        <div id="box-show-message-verify-email">
            <script>
                buildMessageVerifyEmail();
            </script>
        </div>                                         
    @endif          
    @yield('content')
@endsection