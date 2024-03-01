

@extends('supplier.layout')
{{-- @extends('layouts.app') --}}
@section('content')
<br><br><br><br>
<div class="container">
    <div class="box-white" style="padding:20px; background-color: white; ">

        <table class="table table-hover table-striped table-bordered" border="1">
            <tr>
                <th>Số phiếu đặt</th>
                <th>Mã nhà cung cấp</th>
                <th>Ngày đặt</th>
                <th>Tổng số lượng</th>
                <th>Thành tiền</th>
                <th></th>
            </tr>
            @foreach ($orders as $order)
            <tr>
                <td>{{$order->SoPhieuDatHang}}</td>                                
                <td>{{$order->MaNCC}}</td>                
                <td>{{$order->NgatDat}}</td>                
                <td>{{$order->TongSL}}</td>                
                <td>{{$order->ThanhTien}}</td>  
                <td>
                    <a href="/supplier/{{$order->SoPhieuDatHang}}/handle" class="btn btn-info">Xử lý</a>                    
                </td>              
            </tr>
        @endforeach
        </table>

    </div>
  
</div>
@endsection
