<link href="{{ asset('css/jadeLight/guarentee.css') }}" rel="stylesheet">
@extends('layouts.layoutdashboard')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div style="margin-top:30px; padding: 30px; background-color: #FFF;">
{{-- {{ $dataYCBHs }} --}}
<div class="col-md-12"> 
    <h1>THÔNG TIN BẢO HÀNH - SỬA CHỮA</h1>
    <div class="row">
        <div class="col-md-6">
            <div>
                <p>Hóa đơn mua hàng: {{$dataYCBHs[0]->id}}</p>
                <p > Số lượng yêu cầu bảo hành: <span id="SLBH">{{$dataYCBHs[0]->SoLuong}}</span> </p>
            </div>
            <div>
                <p>Ngày xử lý: </p>
               <form method="get">
               @csrf
                    <div class="mb-3">
                        <label for="txt_slThayMoi" class="form-label">Số lượng thay mới</label>
                        <input type="number" class="form-control" id="slThayMoi"  name="txt_slThayMoi">
                    </div>
                    <div class="mb-3">
                        <label for="txt_slSuaChua" class="form-label">Số lượng sửa chữa</label>
                        <input type="number" class="form-control" id="slSuaChua" name="txt_slSuaChua" rows="3"></input>
                    </div>
                    <div class="mb-3">
                        <label for="txt_slSuaChua" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="moTa" name="txt_moTa" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="txt_slSuaChua" class="form-label">Thành tiền</label>
                        <input class="form-control" id="thanhTien" name="txt_thanhTien" rows="3" placeholder="Nhập thành tiền"> </input>
                    </div>
                    
                </form>
                <button id="btnThemhDBH" class="btn btn-primary"> Xác nhận </button>

            </div>
        </div>
        <div class="col-md-1">

        </div>
        <div class="col-md-3">
              <img style="width: 100%;" src="{{asset('images/'. $dataYCBHs[0]->HinhAnh)}}">  
              <p>{{$dataYCBHs[0]->TenHang}}</p>
        </div>
    </div>

</div>
 
    
</div>

<script>
    let YCBH = @json($dataYCBHs[0]);
</script>
<script src="{{ asset('js/jadeLight/orderHandelGuarentee.js') }}"></script>


@endsection


