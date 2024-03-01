

@extends('layouts.app')
@section('content')
<style>
    .box-shadow{
        display: flex;
        justify-content: center;
        align-items: center;  
        position: relative;      
    }
    .link-order{
        position: absolute;
        bottom: 300px;
        left: 50%;
        transform: translate(-50%);       
    }
    .link-order a{
        color: black;
    }
</style>
    <div class="container box-shadow" style="min-height: 700px;">
        <div>
            <center>
                <h1>Xác thực đặt hàng thất bại!!!</h1>
                <h4>{{$error}}</h4>
            </center>
        </div>        
       @if (Auth::check())
        <div class="link-order">
            <a href="/trang-ca-nhan/don-hang">Nhấn vào đây để xem thông tin đơn hàng</a>
        </div>
       @endif
    </div>
@endsection
