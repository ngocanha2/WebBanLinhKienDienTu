@extends('layouts.layoutdashboard')
@section('content')  

    <h2 style="margin-top: 50px; text-align: center; color: brown;"><b>THÔNG TIN SẢN PHẨM</b></h2>    
    <div class="row" style=" border-radius: 10px; background-color: white; width: 95%; margin-left: 20px;">
        @foreach ($hanghoas as $sp)
        <form method="POST" id="form-update-product" action="{{ route('update-product-store', ['id'=>$sp->MaHang]) }}" enctype="multipart/form-data">
            @csrf
            <div class="col-md-8" style="margin-top: 50px; width: 30%; float: left;">
                <img src = "{{ asset('images/'. $sp->HinhAnh)}}" style="width: 100%; padding: 5px"> 
                <p style="margin-left: 20px;">Ảnh hiện tại</p>
                            <input type="file" name="hinh_anh" id="btn_ChonAnh"><br><br>
                            <div class="avatar-preview" id="list_hinh" update-product = "1" style="width: 100%; height: 300px; box-shadow: 2px 5px 5px 2px rgb(43, 162, 214)">
                                
                            </div>
                            <label style="margin-left: 20px;">Chọn ảnh mới</label>
            </div>
            <div class="col-md-8"  style="float: right; margin-top: 50px; ">
                    <p><b>Tên sản phẩm</b><input class="form-control" type="text" name="txt_Ten" id="tenSP" value="{{$sp->TenHang }}"></p>
                    <p><b>Giá bán: </b><input class="form-control" type="text" name="txt_GiaBan" id="giaBan" value="{{$sp->GiaBan }}"></p>
                    <p><b>Số lượng tồn:</b><input class="form-control" type="text" name="txt_SLTon" id="slTon" value="{{$sp->SoLuongTon }}"></p>
                    <p><b>Thời gian bảo hành: </b><input class="form-control" type="text" name="txt_TGBaoHanh" id="tgBaoHanh" value="{{$sp->ThoiGianBaoHanh }}"> <span>tháng</span></p>
                    <p><b>Loại hàng: </b></p>
                    <select name="cbo_DanhMuc" class="form-control" >
                    @foreach ($danhmucs as $dm)     
                        <option value="{{$dm->MaDanhMuc}}">{{$dm->TenDanhMuc}}</option>
                    @endforeach
                    @foreach ($danhmucall as $dma)
                        {{-- <input type="text" value="{{$km->TyLeGiamGia }}"> %</p> --}}
                        <option value="{{$dma->MaDanhMuc}}">{{$dma->TenDanhMuc}}</option>
                    @endforeach
                    </select>
                        <p><b>Tỷ lệ giảm giá: </b></p>
                    <select name="cbo_KhuyenMai"  class="form-control">
                    @foreach ($khuyenmais as $km) 
                        <option value="{{$km->MaKM}}">{{$km->TyLeGiamGia}}%</option>
                    @endforeach
                    @foreach ($khuyenmaiall as $kma)
                        {{-- <input type="text" value="{{$km->TyLeGiamGia }}"> %</p> --}}
                        <option value="{{$kma->MaKM}}">{{$kma->TyLeGiamGia}}%</option>
                    @endforeach
                    </select><br>
                        <p><b>Mô tả: </b></p>
                        <textarea class="form-control" name="txt_MoTa" id="moTa" style="height: 200px;width: 100%;">{{$sp->MoTa }}</textarea><br>
                    <a href="{{route('update-product-store',['id'=>$sp->MaHang]) }}"><button type="submit" class="btn btn-warning" style="width: 100px; margin-left: 0px" value="btn_Sua" id="Sua" >Sửa</button></a>
            </div>
        </form>
            </div>
        </div>
        @endforeach
<script>$("#menu-item-product").addClass("active")</script>
<script src="{{ asset('js/doman/productstore.js') }}"></script>
@endsection