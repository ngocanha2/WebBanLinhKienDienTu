<link href="{{ asset('css/jadeLight/guarentee.css') }}" rel="stylesheet">

@extends('layouts.layoutdashboard')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- {{ dd($datayeucaubaohanhs) }} --}}
<div style="padding-top:30px 0px;  min-height: 600px; background-color: #FFF;">
    <div class="col-md-12">
        <div class="status-group status-group-js">
            <div class="title-status active" id="all">Tất Cả </div>
            <div class="title-status" id="needHandle">Cần xử lý </div>
            <div class="title-status" id="Handling">Đang Xử lý </div>
            <div class="title-status" id="Handled">Đã Xử lý </div>
            <div class="title-status" id="Handled">Đã hủy </div>
            <!-- <div>Đã hủy </div> -->
        </div>
    <!-- nội dung -->
        <div> 
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Mã sản phẩm </th> 
                        <th scope="col">Tên sản phẩm </th> 
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thời gian bảo hành</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Tên khách hàng</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Ngày mua hàng</th>
                        <th scope="col">Ngày yêu cầu</th>
                        <th scope="col">Trạng thái </th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody class="contentStatus">
               
                </tbody>
            </table>
        </div>

        
    <!--end nội dung -->
    </div>
</div>


<script>
    let YCBH = @json($datayeucaubaohanhs);
</script>
<script src="{{ asset('js/jadeLight/guarentee.js') }}"></script>

@endsection


