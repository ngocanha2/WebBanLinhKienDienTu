<link href="{{ asset('css/styleDetailproduc.css') }}" rel="stylesheet">
@extends('layouts.app')
@section('content')
<style>
    .icon-num{
        cursor: pointer;
        font-size: 30px;
    }
    .sale-product-price{
        font-size: 20px;
        color: #747474;
        text-decoration: line-through;
    }
    .discount-ratio{
        padding: 2 5;
        background: crimson;
        color: white;
        border-radius: 5px;
        font-size: 17px;
    }
</style>
<div class="group-detail-product" >
    <div class="col-md-4 group-all-img">
        <img class="img-main" src="{{ asset('images/'. $hanghoas->HinhAnh)}}">
        <!-- load ds hình -->
        <div class="group-imgs">
                @foreach($hinhanhs as $hinh) 
                <div class="group-img" > 
                    <img src="{{asset('images/'.$hinh->TenHinh)}}" > 
                </div>
                @endforeach
        </div>
    </div>
    <div class="col-md-7 group-content-detail">
        <h3 class="name-product">{{$hanghoas->TenHang}}</h3>
        <?php
            if(0<$danhgiatb && $danhgiatb<=0.5) 
                $im = "NuaSao.jpg";
            if(0.5<$danhgiatb && $danhgiatb<=1) 
                $im = "1Sao.png";
            if(1<$danhgiatb && $danhgiatb<=1.5) 
                $im = "1SaoRuoi.jpg";
            if(1.5<$danhgiatb && $danhgiatb<=2) 
                $im = "2Sao.png";
            if(2<$danhgiatb && $danhgiatb<=2.5) 
                $im = "2SaoRuoi.jpg";
            if(2.5<$danhgiatb && $danhgiatb<=3) 
                $im = "3Sao.png";
            if(3<$danhgiatb && $danhgiatb<=3.5) 
                $im = "3SaoRuoi.jpg";
            if(3.5<$danhgiatb && $danhgiatb<=4) 
                $im = "4Sao.png";
            if(4<$danhgiatb && $danhgiatb<=4.5) 
                $im = "4SaoRuoi.jpg";
            if(4.5<$danhgiatb && $danhgiatb<=5) 
                $im = "5Sao.png";
            if($danhgiatb ==null) 
                $im = "0Sao.jpg";
        ?>
        <img src="{{asset('images/'.$im)}}" style="width: 170px;"><span>{{round($danhgiatb,1)}}</span>
        @if ($hanghoas->GiaKhuyenMai!=$hanghoas->GiaBan)
        <br><br><div>
                <span class="sale-product-price"> {{number_format($hanghoas->GiaBan,0,',','.')}} VNĐ </span><span> <span class="discount-ratio"> -{{$hanghoas->TyLeGiamGia}}%</span></span> 
            </div>                    
        @endif
        <div class="group-cost">             
           <div><p><span class="cost-product" style="color: red">{{number_format($hanghoas->GiaKhuyenMai,0,',','.')}} VNĐ</span>   </p> </div>
            <!-- @if ($hanghoas->SoLuongTon > 0)
            <div class="stocking">Tình trạng: Còn hàng</div>
            @else
                <div class="run-ot-of">Tình trạng: Hết hàng</div>
            @endif -->
             
        </div>

        <form action="" method="POST" id="form-add-product-to-cart">
            <!-- <p>Số lượng còn lại:  {{$hanghoas->SoLuongTon}} </p> -->
            <div style="display: flex;flex-direction: row;align-items: center; gap: 30px">

                <div class="">                
                    <div class="item-control-quantity row">
                        <h6>Số lượng:</h6>
                        <div class="box-edit-quantity">
                            <a class="btn btn-outline-info add " >+</a>
                            <input type="text" name="so_luong" class="show-quantity border-info" value="{{$hanghoas->SoLuongTon > 0 ? 1 : 0}}" />
                            <a class="btn btn-outline-info minus" >-</a>                                        
                            <a style="padding-left:10px;" hidden><span id="item-present-quantity" class="item-present-quantity"> {{$hanghoas->SoLuongTon}}</span> sản phẩm có sẳn</a>
                        </div>
                        <script>
                            ValidateQuantity($(".box-edit-quantity")[0])
                        </script>
                    </div> 
                    {{-- <div class="icon-num">
                        +
                    </div>
                    <span class="number"> 0 </span>
                    <div class="icon-num" > 
                        -
                    </div> --}}
                </div>  

                <div> 
                    @if ($hanghoas->SoLuongTon > 0)
                <div class="stocking">  Số lượng còn: {{$hanghoas->SoLuongTon}}</div>
                    @else
                        <div class="run-ot-of">Tình trạng: Hết hàng</div>
                    @endif
                </div>

            </div>
            <div style="display: flex; flex-direction: row; gap: 20px; margin-top: 20px" >
                {{-- <button type="button" class="btn btn-outline-primary">Mua Ngay</button> --}}
                <button type="submit" class="btn btn-primary" id="btn-add-to-cart"> Thêm vào giỏ hàng </button>
            </div>
        </form>
        
    </div>
</div>

<div class="describe-product">
    <h2> Mô tả sản phẩm</h2>
    <p>{{ $hanghoas->MoTa }}</p>
</div>


{{-- Đánh giá (Mẫn) --}}
<div style="background-color: white; border-radius: 10px; width: 95%; margin: 0 auto; margin-left: 30px;">
    <h2 style="padding: 10px;">Đánh giá sản phẩm</h2>
    @if (count($danhgias)==0)
        <center><h3>Không có đánh giá</h3></center>
    @else
        @foreach ($danhgias as $dg)
        <?php
            if($dg->MucDoHaiLong == 5)
                $image = "5Sao.png";
            else if($dg->MucDoHaiLong == 4)
                $image = "4Sao.png";
            else if($dg->MucDoHaiLong == 3)
                $image = "3Sao.png";
            else if($dg->MucDoHaiLong == 2)
                $image = "2Sao.png";
            else
                $image = "1Sao.png";
            if($dg->AnDanh == 0)
                $hoTen = $dg->HoVaTen;
            else
                $hoTen = "**********";
        ?>
        
            <div style="padding: 10px;">
                <p>{{ $hoTen }} </p>
                {{-- <p style="margin-left: 40px;">Số sao: {{ $dg->MucDoHaiLong }}</p> --}}
                <img src="{{asset('images/'.$image)}}" style="width: 150px;">
                <p style="margin-top: 20px;">{{ $dg->NoiDungDanhGia }}</p>
                <hr style="color: rgb(2, 2, 2)">
                {{-- <button style="display: none">Không có đánh giá nào</button>
                @if($dg->MucDoHaiLong == NULL)
                    <button>Không có đánh giá nào</button>
                @endif --}}
            </div>                
        @endforeach
    @endif    
</div>

<script src="{{asset("js/handle/product/product.details.js")}}"></script>
@endsection

