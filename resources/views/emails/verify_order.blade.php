<center>
    @if (isset($data['DonHang']["MaKH"]))
        <h1>Bạn đã đặt một đơn hàng trên website của chúng tôi</h1>
        <p>Xin chào, rất vui vì bạn đã đăng ký sử dụng dịch vụ của chúng tôi</p>
        <p>Nhấn vào nút phía bên dưới để xem chi tiết đơn hàng</p>
        <a href="{{asset('personal/order/'.$data['DonHang']['MaDonhang'])}}" style="border: 5px; border-radius:5px; background-color: crimson; color: white; padding: 20px; font-size:17px; text-decoration: none">Xem chi tiết</a>
    @else
        <h1>Xác thực Email để hoàn tất quá trình đặt hàng</h1>
        <p>Xin chào, rất vui vì bạn đã đăng ký sử dụng dịch vụ của chúng tôi</p>
        <p>Vui lòng nhấn vào nút phía bên dưới để hoàn tất quá trình đặt hàng</p>
        <a href="{{asset('/verify-order/'.$data['DonHang']['MaDonhang'].'/'.$data['DonHang']['token'])}}" style="border: 5px; border-radius:5px; background-color: black; color: white; padding: 20px; font-size:17px; text-decoration: none">Xác nhận đơn hàng</a>   
    @endif    
    <br>
    <br>
    <br>
    <span>Nếu bạn không đặt hàng, vui lòng bỏ qua email này</span>
</center>
