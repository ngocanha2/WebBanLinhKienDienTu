<link href="{{ asset('css/jadeLight/guarentee.css') }}" rel="stylesheet">
@extends('layouts.layoutdashboard')
@section('content')


<div style="padding:30px; background-color: #FFF;">
   <h1 style="text-align: center; color: #a52a2a;"> THÔNG TIN XỬ LÝ BẢO HÀNH - SỬA CHỮA </h1> 
   <br>
    <div class="col-md-12"> 
        <div style="display: flex; flex-direction: row;  justify-content: space-evenly;">
            <div style="width: 40%; font-size: 24px; margin-top: 20px;"> 
                <p>
                   <b>Mã yêu cầu bảo hành: </b> {{$dataHDs[0]->YeuCauBaoHanhId}}
                </p>
                <p>
                   <b>Ngày tạo: </b>{{$dataHDs[0]->NgayTao}}
                </p>
                <p>
                   <b>Số lượng thay mới: </b> {{$dataHDs[0]->SoLuongThayMoi}}
                </p>
                <p>
                   <b> Số lượng sửa chữa: </b> {{$dataHDs[0]->SoLuongSuaChua}}
                </p>
                <p>
                  <b>Mô tả: </b> {{$dataHDs[0]->MoTa}}
                </p>
                <p>
                   <b>Thành tiền:  </b>{{$dataHDs[0]->ThanhTien}} VNĐ
                </p>
            </div>    
           
            <div style="width: 30%;">
                <img style="width: 100%;" src="{{asset('images/'.$dataHDs[0]->HinhAnh)}}"> 
                
                <p style="text-align: center; margin-top: 10px; font-size: 20px;"> {{$dataHDs[0]->TenHang}}</p>
            </div>
        </div>
    </div>
    
</div>
@endsection


