

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
        <center>
            <div>
                <h1>Đặt hàng thành công!!!</h1>           
            </div>
            @if (Auth::check())
                <div class="link-order">
                    <a href="/personal/order/{{$_GET["id"] ?? ""}}">Nhấn vào đây để xem thông tin đơn hàng</a>
                </div>
                @elseif (isset($_GET["token"]))                    
                    <div>
                        <h4>Vui lòng lưu giữ mã này để xem thông tin đơn hàng:</h4>
                        <h2 class="token" style="color: crimson">{{$_GET["token"]}}</h2>                                                
                    </div>                    
                @else
                    <div class="link-order">
                        <a href="https://mail.google.com">Xác thực email của bạn để hoàn tất quá trình đặt hàng</a>
                    </div>
            @endif
        </center>
    </div>
@endsection
