@extends('layouts.layoutdashboard')
@section('content')
<head>
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> --}}

    {{-- Library datepicker --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.vi.min.js"></script>

    {{-- Library chart --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <style>
        .ngay{
            margin-left: 170px;
            margin-bottom: 20px;
            margin-top: 10px;
        } 
        .form-control
        {
            margin-left: 30px;
        }
        .notice {
        font-style: italic;
        font-size: 0.8em;
    }       
    </style>
</head>

<div class="col-12 p-lg-4" style="background-color: white; border-radius: 10px;  width: 100%;">
    <h2 style="text-align: center; color: brown; font-weight: bold; padding: 20px">THỐNG KÊ BÁN HÀNG</h2><br>
    
    <form id="form-statistical" method="GET">
        <div class="row">
            <div class="col-md-9">
                <span><label class="ngay">Từ ngày</label>
                <input type="text" id="NgayBatDau" name="txt_NgayBD" class="form-control" placeholder="Chọn ngày bắt đầu"></span>
                <label class="ngay">Đến ngày</label>
                <input type="text" id="NgayKetThuc" name="txt_NgayKT" class="form-control" placeholder="Chọn ngày kết thúc">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary" name="btn_ThongKe" style="margin-left: 70px;">Thống kê</button>
            </div>
        </div>
        <div style="margin-left: 5px; margin-right: 5px;">
            <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px; align-content:center;text-align:center;justify-content:center;align-items:center;">
                <thead>
                    <tr>
                        <th>Số đơn hàng</th>
                        <th>Tổng doanh thu</th>
                    </tr>
                    <tr>
                        <td style="text-align: center">{{$sodonhang }}</td>
                        <td style="text-align: center">{{ $tongtien }}</td>
                    </tr>
                </thead>
            </table>
            <table class="hver table table-hover table-light table-striped table-bordered" border="1" style=" margin-top:20px; align-content:center;text-align:center;justify-content:center;align-items:center;">
                <thead>
                    <tr>
                        <th>Danh sách sản phẩm đã bán</th>
                        <th>Số lượng đã bán</th>
                        <th>Đánh giá</th>
                    </tr>
                        
                        @foreach ($dssanpham as $ds)
                        <?php 
                            if(0<$ds->DanhGia && $ds->DanhGia<=0.5) 
                                $im = "NuaSao.jpg";
                            if(0.5<$ds->DanhGia && $ds->DanhGia<=1) 
                                $im = "1Sao.png";
                            if(1<$ds->DanhGia && $ds->DanhGia<=1.5) 
                                $im = "1SaoRuoi.jpg";
                            if(1.5<$ds->DanhGia && $ds->DanhGia<=2) 
                                $im = "2Sao.png";
                            if(2<$ds->DanhGia && $ds->DanhGia<=2.5) 
                                $im = "2SaoRuoi.jpg";
                            if(2.5<$ds->DanhGia && $ds->DanhGia<=3) 
                                $im = "3Sao.png";
                            if(3<$ds->DanhGia && $ds->DanhGia<=3.5) 
                                $im = "3SaoRuoi.jpg";
                            if(3.5<$ds->DanhGia && $ds->DanhGia<=4) 
                                $im = "4Sao.png";
                            if(4<$ds->DanhGia && $ds->DanhGia<=4.5) 
                                $im = "4SaoRuoi.jpg";
                            if(4.5<$ds->DanhGia && $ds->DanhGia<=5) 
                                $im = "5Sao.png";
                            if($ds->DanhGia ==null) 
                                $im = "0Sao.jpg";
                        ?>
                        <tr>
                            <td style="text-align: center">{{ $ds->TenHang }}</td>
                            <td style="text-align: center">{{$ds->TongSoLuong }}</td>
                            <td><img src="{{asset('images/'.$im)}}" style="width: 170px;"></td>
                            {{-- <td style="text-align: center">{{$ds->DanhGia }}</td> --}}
                        </tr>
                            
                        @endforeach
                        
                    
                </thead>
            </table>
            @foreach ($spchaynhat as $sp)
                <p style="margin-left: 30px;">Sản phẩm bán chạy nhất <span style="color: red">{{ $sp->TenHang }}</span></p>        
            @endforeach
            <br>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                @php
                if(isset($_GET["cbo_Nam"]))
                    $nam = $_GET["cbo_Nam"];
                    // echo($nam);
                @endphp
                <select name="cbo_Nam" class="form-control">
                    <option value="2020" {{ isset($nam) && $nam ==2020 ? "selected" : ""}}>2020</option>
                    <option value="2021" {{ isset($nam) && $nam =="2021" ? "selected" : ""}}>2021</option>
                    <option value="2022" {{ isset($nam) && $nam ==2022 ? "selected" : ""}}>2022</option>
                    <option value="2023" {{ !isset($_GET["cbo_Nam"]) ? "selected" : ($nam == 2023 ? "selected" : "")}}>2023</option>
                    {{-- <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026">2026</option>
                    <option value="2027">2027</option>
                    <option value="2028">2028</option>
                    <option value="2029">2029</option>
                    <option value="2030">2030</option>
                    <option value="2031">2031</option>
                    <option value="2032">2032</option>
                    <option value="2033">2033</option>
                    <option value="2034">2034</option>     --}}
                </select>
            </div>
            <div class="col-md-6">
                <button class="btn btn-warning" name="btn_Loc" style="margin-left: 70px;">Lọc</button>
            </div>
        </div>
    </form><br>
    <h4 style="color: rgb(58, 125, 226); margin-left: 30px;">Thống kê theo năm</h4>
    <div id="myChart" style="height: 400px;"></div>
        <script>
            var sodonhangt1 = {!! $sodonnamt1 !!}; var tongtient1 = {!! $tongtiennamt1 !!}; 
            var sodonhangt2 = {!! $sodonnamt2 !!}; var tongtient2 = {!! $tongtiennamt2 !!};
            var sodonhangt3 = {!! $sodonnamt3 !!}; var tongtient3 = {!! $tongtiennamt3 !!}; 
            var sodonhangt4 = {!! $sodonnamt4!!}; var tongtient4 = {!! $tongtiennamt4 !!};
            var sodonhangt5 = {!! $sodonnamt5!!}; var tongtient5 = {!! $tongtiennamt5 !!};
            var sodonhangt6 = {!! $sodonnamt6!!}; var tongtient6 = {!! $tongtiennamt6 !!};
            var sodonhangt7 = {!! $sodonnamt7!!}; var tongtient7 = {!! $tongtiennamt7 !!};
            var sodonhangt8 = {!! $sodonnamt8!!}; var tongtient8 = {!! $tongtiennamt8 !!};
            var sodonhangt9 = {!! $sodonnamt9!!}; var tongtient9 = {!! $tongtiennamt9 !!};
            var sodonhangt10 = {!! $sodonnamt10 !!}; var tongtient10 = {!! $tongtiennamt10 !!};
            var sodonhangt11 = {!! $sodonnamt11 !!}; var tongtient11 = {!! $tongtiennamt11 !!};
            var sodonhangt12 = {!! $sodonnamt12 !!}; var tongtient12 = {!! $tongtiennamt12 !!};
            // console.log(sodonhangt12)
            new Morris.Bar({
            
                element: 'myChart',
                
                data: [
                    { thang: 'T1', sodon:sodonhangt1, doanhthu: tongtient1},
                    { thang: 'T2', sodon:sodonhangt2, doanhthu: tongtient2},
                    { thang: 'T3', sodon:sodonhangt3, doanhthu: tongtient3},
                    { thang: 'T4', sodon:sodonhangt4, doanhthu: tongtient4},
                    { thang: 'T5', sodon:sodonhangt5, doanhthu: tongtient5},
                    { thang: 'T6', sodon:sodonhangt6, doanhthu: tongtient6},
                    { thang: 'T7', sodon:sodonhangt7, doanhthu: tongtient7},
                    { thang: 'T8', sodon:sodonhangt8, doanhthu: tongtient8},
                    { thang: 'T9', sodon:sodonhangt9, doanhthu: tongtient9},
                    { thang: 'T10', sodon:sodonhangt10, doanhthu: tongtient10},
                    { thang: 'T11', sodon:sodonhangt11, doanhthu: tongtient11},
                    { thang: 'T12', sodon:sodonhangt12, doanhthu: tongtient12}
                ],
                
                xkey: 'thang',
                
                ykeys: ['sodon','doanhthu'],
                
                labels: ['Số đơn hàng', 'Doanh thu'],
                barColors: ['rgb(165, 42, 42)','rgb(58, 125, 226)'],
                stacked: true
            });
        </script>
    </div>
<script>
    $(document).ready(function(){
        $("#NgayBatDau").datepicker({
            format: "yyyy-mm-dd", 
            language: "vi",
            autoclose: true,
            todayHighlight: true
        });

        $("#NgayKetThuc").datepicker({
            format: "yyyy-mm-dd", 
            language: "vi",
            autoclose: true,
            todayHighlight: true
        });
    });
</script>
{{-- <script src="{{ asset('js/doman/statistical.js') }}">
</script> --}}
@endsection