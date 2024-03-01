<center>    
    <h1>Thanh toán đơn hàng thành công</h1>
    <p>Xin chào, rất vui vì bạn đã đăng ký sử dụng dịch vụ của chúng tôi</p>
    <p>{{$data['message']}}</p>       
    @if (isset($data['DonHang']["MaKH"]))        
        <p>Nhấn vào nút phía bên dưới để xem chi tiết đơn hàng</p>
        <a href="{{asset('personal/order/'.$data['DonHang']['MaDonhang'])}}" style="border: 5px; border-radius:5px; background-color: crimson; color: white; padding: 20px; font-size:17px; text-decoration: none">Xem chi tiết</a>
    @else
        <p>Đây là mã đơn hàng của bạn, vui lòng lưu giữ để truy cập thông tin đơn hàng:</p>
        <h1>{{$data['DonHang']["token"]}}</h1>
        <a href="{{asset('/search')}}?txt_search=/{{$data['DonHang']["token"]}}" style="border: 5px; border-radius:5px; background-color: crimson; color: white; padding: 20px; font-size:17px; text-decoration: none">Xem chi tiết</a>
    @endif
    <br>
    <br>
    <br>
</center>
