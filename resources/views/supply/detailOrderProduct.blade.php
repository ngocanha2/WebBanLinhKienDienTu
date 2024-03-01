@extends('layouts.layoutdashboard')
@section('content')
<div class="row" style="margin-top:30px">
    <div class=""> 
        <center> <h2> Phiếu đặt hàng</h2> </center>
        <div> 
            <div class="info-common"> 
          
                <p>Mã phiếu đặt: {{$PhDatHangs->SoPhieuDatHang}}</p>
                <p>Nhân viên: {{$PhDatHangs->TenNV}} | {{$PhDatHangs->MaNV}}</p>
                <p>Ngày: {{$PhDatHangs->NgatDat}}</p>
                <p>Nhà cung cấp: {{$PhDatHangs->TenNCC}}</p>
            </div>
            <h4>Chi tiết đặt hàng </h4>
            <table class="table table-hover table-striped table-bordered" border="1">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Mã hàng </th>
                        <th scope="col">Tên hàng</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Đơn giá</th>
                        <th scope="col">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                
                @foreach($CTPhDatHang as $index => $ct)
                    <tr> 
                        <td scope="row"> {{$index+1}}</td>
                        <td>{{$ct->MaHang }}</td>
                        <td>{{$ct->TenHang }}</td>
                        <td><img style="width: 100px" src="{{ asset('images/'. $ct->HinhAnh)}}"></td>
                        <td>{{$ct->SoLuong }}</td>
                        <td>{{$ct->DonGia }}</td>
                        <td>{{$ct->SoLuong * $ct->DonGia }} VNĐ</td>
                    </tr>
                @endforeach
                </tbody>
                <tfood>
                    <tr>
                        <td colspan="5">  </td>
                        <td> Tổng tiền: </td>
                        <td > {{$PhDatHangs->ThanhTien}} VNĐ</td>
                    </tr>
                </tfood>
            </table>
        </div>
    </div>
</div>
<script>
    $("#menu-item-supply-order").addClass("active")
</script>
@endsection