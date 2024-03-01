

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
            <h1>Đặt hàng không thành công!!!</h1>            
        </div>       
    </div>
@endsection
