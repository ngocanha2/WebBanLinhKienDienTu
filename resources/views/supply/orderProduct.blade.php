<link href="{{ asset('css/jadeLight/orderProduct.css') }}" rel="stylesheet">
@extends('layouts.layoutdashboard')
@section('content')
<div class="box-white p-2" style="min-height: 750px">
    <form id="hoaDonForm"> 
        <div class="row justify-content-center"  style="margin-top:40px">
            <div class="col-md-10"> 
                <label class="form-label" for="nhaCungCap"> Nhà cung cấp</label>
                    <select class="form-select " aria-label="Default select example" id="nhaCungCap">
                        <option value="-1" selected>--Chọn nhà cung cấp--</option>
                        @foreach($NCCs as $ncc)
                            <option value="{{$ncc->MaNCC}}">{{$ncc->TenNCC}} </option>
                        @endforeach
                    </select>
    
                    <label class="form-label" for="nguonHangAll"> Mặt hàng</label>
                    <select class="form-select" aria-label="Default select example" id="nguonHangAll">
                        <option value="-1" selected>--Chọn nguồn hàng--</option>
                    @foreach($supplys as $index => $s)
                            <option class="product" value="{{$s->MaNCC}}-{{$s->MaHang}}-{{$loop->index}}">{{$s->GiaNhap}} - {{$s->TenHang}}  </option>
                        @endforeach      
                    </select>
            
    
                <div class="mb-3">
                    <label for="quantity" class="form-label">Số lượng</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Nhập số lượng">
                </div>
                <div class="group-btn-handel">
                    <div class="btn btn-primary width-130" id="addProductOrder">Thêm</div>
                </div>
                <p></p>
            </div>    
        </div>
    
        <div class="row justify-content-center">
            <div class="col-md-11">
                <table class="table table-hover" id="tableOrderProduct">
                    <thead>
                        <tr>
                        <th scope="col">Mã hàng</th>
                            <th scope="col">Tên hàng</th>
                            <th scope="col">Đơn giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
    
                    <tbody>
                    </tbody>
                    
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            
                            <td colspan="2"> Tổng tiền</td>
                            <td id="sumCost">0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    
                </table>
            </div>    
        </div>
    
        <div class="row justify-content-center">
            <div class="col-md-5 row justify-content-end"> 
               
                <!-- <button type="submit" id="insertDataSupply"  class="btn btn-primary "> Đặt hàng</button>  -->
                <div  id="insertDataSupply"  class="btn btn-primary "> Đặt hàng</div>
            </div>
        </div>
    </form>
</div>
<!------------------------ MỚI CODE--------------- -->
<script>
    let hangHoas = @json($supplys);
    $("#menu-item-supply-order").addClass("active")
    // $controller = new YourControllerName();
    // $controller->insertData($maHang);
</script>
<script src="{{ asset('js/library.message-box.js') }}"> </script>
<script src="{{ asset('js/jadeLight/supply.js') }}"></script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Script tương ứng với việc thêm/xóa dòng trong bảng -->
    <script src="public/js/your_script.js"></script>

    <!-- Ví dụ: Tải jQuery từ CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection

