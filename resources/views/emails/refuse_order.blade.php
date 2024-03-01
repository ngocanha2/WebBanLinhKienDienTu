<center>    
    <h1>Thông báo tình trạng đơn hàng</h1>
    <p>Xin chào, rất vui vì bạn đã đăng ký sử dụng dịch vụ của chúng tôi</p>
    <p>Đơn hàng của bạn đã bị từ chối</p> 
    <p>Lý do: {{$data['DonHang']["GhiChu"]}}</p> 
    @if (isset($data['DonHang']["MaKH"]))        
        <p>Nhấn vào nút phía bên dưới để xem chi tiết đơn hàng</p>
        <a href="{{asset('personal/order/'.$data['DonHang']['MaDonhang'])}}" style="border: 5px; border-radius:5px; background-color: crimson; color: white; padding: 20px; font-size:17px; text-decoration: none">Xem chi tiết</a>
    @endif
    <br>
    <br>
    <br>
</center>
