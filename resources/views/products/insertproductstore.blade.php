@extends('layouts.layoutdashboard')
@section('content')
<link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

    
<div class="col-md-12" >
    <div class="row">
        <div style="margin-top:50px; width:100% ;display: flex; flex-direction: row; flex-wrap: wrap; gap: 30px;background-color: white; border-radius: 10px; padding: 10px">
            <div style="width: 100%;">
                <h2 style="text-align: center; color: brown; font-weight: bold">NHẬP THÔNG TIN SẢN PHẨM</h2><br>
                <form id="form-update-product" action="{{route('insert-product-store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label>Hình ảnh</label>
                            <input type="file" name="hinh_anh" id="btn_ChonAnh"><br><br>
                            <div class="avatar-preview" id="list_hinh" style="width: 300px; height: 300px; box-shadow: 2px 5px 5px 2px rgb(43, 162, 214)">
                                <img>
                            </div>
                        </div>
                        <div class="col-md-7" style="margin-left: 20px;">
                            <p>Tên sản phẩm<input class="form-control" type="text"  name="txt_TenHang" id="tenSP" ></p>
                            <p>Giá bán<input class="form-control" type="number" oninput="createInputNumber($(this),0)"  name="txt_GiaBan" id="giaBan"></p>
                            <p>Số lượng tồn kho<input class="form-control" type="number" oninput="createInputNumber($(this),0)"  name="txt_SoLuongTon" id="slTon"></p>
                            <p>Thời gian bảo hành<input class="form-control" type="number" oninput="createInputNumber($(this),0)" name="txt_TGBaoHanh" id="tgBaoHanh"></p>
                            <label>Danh mục</label>
                            <select class="form-control" name="cbo_DanhMuc">
                                @foreach ($danhmucs as $dm)
                                    <option value="{{$dm->MaDanhMuc}}">{{$dm->TenDanhMuc}}</option>
                                @endforeach  
                            </select><br>
                            <label>Khuyến mãi</label>
                            <select class="form-control" name="cbo_KhuyenMai" >
                                @foreach ($khuyenmais as $km)
                                    <option value="{{$km->MaKM}}">{{$km->TenKhuyenMai}} - {{$km->TyLeGiamGia}}% ({{$km->NgayBatDau}} - {{$km->NgayKetThuc}})</option>
                                @endforeach  
                            </select><br>
                            <p>Mô tả <textarea class="form-control" name="txt_MoTa" id="moTa" style="margin-top: 35px; height: 200px;width: 500px;"></textarea></p>
                        </div>    
                    </div>
                    <center><a href="{{route('insert-product-store')}}"><button class="btn btn-danger" name="btn_XacNhan" style="margin-bottom: 10px; margin-top: 50px;">Lưu sản phẩm mới</button></a></center>
                </form> 
            </div>
        </div>
    </div>
</div>
<script>
    $("#menu-item-product").addClass("active")
</script>
<script src="{{ asset('js/doman/productstore.js') }}"></script>
@endsection