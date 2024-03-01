<!-- <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{request()->is('/') ? 'activ' :'' }} " aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{request()->is('products') ? 'activ' :'' }} " href="/products">products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('pages')?'activ':'' }}" href="/pages">pages</a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link disabled">Disabled</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav> -->


  <style>
    ul {
        list-style: none;
    }

        ul li a {
            color: black;
        }
</style>

<div style=" background-color: #f5f5fa"> 
    <div style="margin-top:-5px;">
    <!-- ?? -->
        <nav class="navbar navbar-expand-lg bg-info" style="padding-bottom:0px;margin-top:-5px; position:fixed; left:0; width:100%; z-index:10;">
            <div class="container">
                <nav class="navbar" style=" width:150px; cursor: pointer; border-radius: 15px; padding:0px; margin:7px; padding-left: 10px;">
                    <a class="navbar-brand bg-info" href="/"  style=" display: flex;flex-direction: column; align-items: center; justify-content: center;">
                        
                        <div> <img style="width:50px" src="{{asset('storage/images/logo.png')}}"></div>
                        <!-- <span style="">Bee Shop</span> -->
                    </a>
                </nav>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <form action="{{ route('search') }}" class="d-flex search" role="search" method="GET">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown">
                                <a class="nav-link active gio" aria-current="page">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-ui-checks-grid" viewBox="0 0 16 16">
                                        <path d="M2 10h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1zm9-9h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-3a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zm0 9a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1h-3zm0-10a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2h-3zM2 9a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h3a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H2zm7 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-3a2 2 0 0 1-2-2v-3zM0 2a2 2 0 0 1 2-2h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm5.354.854a.5.5 0 1 0-.708-.708L3 3.793l-.646-.647a.5.5 0 1 0-.708.708l1 1a.5.5 0 0 0 .708 0l2-2z" />
                                    </svg>
                                </a>
                                <div class="dropdown-content">
                                    <ul>
                                       
                                    </ul>
                                </div>
                            </li>
                        </ul>
                        <input class="form-control me-2 " type="search" name="txt_search" placeholder="Tìm kiếm sản phẩm, thông tin đơn hàng (cú pháp tìm đơn hàng: '/[mã đơn]')" aria-label="Search" style="margin-left:5px;">
                        <button class="btn btn-outline-light" type="submit"><i class="bi bi-search"></i></button>
                    </form>

                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <center>
                        <li class="nav-item" style="margin-left:-10px">
                            <a class="nav-link active gio" aria-current="page" style="width:90px;" href="{{route("cart")}}">
                                <center class=" position-relative" >
                                    <span id="item-show-cart-quantity"> 
                                        <script>
                                            loadCartQuantity()
                                        </script>                                        
                                    </span>                                                                        
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cart3" viewBox="0 0 16 16">
                                        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .49.598l-1 5a.5.5 0 0 1-.465.401l-9.397.472L4.415 11H13a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l.84 4.479 9.144-.459L13.89 4H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                    </svg>
                                    <p>Giỏ hàng</p>
                                </center>
                            </a>
                        </li>
                        </center>
                        <center>
                        <li class="navbar" style="min-width:200px;text-align:center;  position:relative;">
                            <div class="nav-item dropdown">
                                <a class=" nav-link user" href="{{route(($user = Auth::user()) ? "personal-infomation" : "login")}}" style=" min-width:200px; align-items:center; text-align:center;">
                                    <svg style="float:left; margin-top:-10px; margin-bottom:-10px;" xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                                    </svg>
                                    <span style="font-size:{{Auth::check() ? 15:12}}px; float:left">{{Auth::check() ? "-----Xin chào-----":"Đăng nhập/Đăng ký"}}</span>
                                    <p style="margin-top:-2px;">
                                        @if (Auth::check())                                                                              
                                            <span>{{$user->TenDangNhap}}</span>
                                        @else
                                            <span>Tài khoản</span> 
                                        @endif
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z" />
                                        </svg>
                                    </p>
                                </a>                                                                                                                                                                  
                                <div class=" dropdown-content" id="menutcn" style="width:170px; margin-left:10px;">
                                    <ul style="width:170px;">
                                        @if (Auth::check())                                                                              
                                            <li style="width:170px;">
                                                <a href="{{route("personal-infomation")}}"><i class="bi bi-person-vcard"></i> Trang cá nhân</a>
                                            </li>
                                            <li style="width:170px;">
                                                <a href="{{route("logout")}}"><i class="bi bi-box-arrow-left"></i> Đăng xuất</a>
                                            </li>
                                        @else
                                            <li style="width:170px;">
                                                <a href="{{route("login")}}"><i class="bi bi-box-arrow-in-right"></i> Đăng nhập</a>
                                            </li>
                                            <li style="width:170px;">
                                                <a href="{{route("register")}}"><i class="bi bi-node-plus"></i> Đăng ký</a>
                                            </li>
                                        @endif                                            
                                    </ul>
                                </div>                                                                                             
                            </div>
                            {{-- <a class="banhang" href="/KenhBanHang/KenhBanHang">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shop-window" viewBox="0 0 16 16" style="margin-top:-5px">
                                    <path d="M2.97 1.35A1 1 0 0 1 3.73 1h8.54a1 1 0 0 1 .76.35l2.609 3.044A1.5 1.5 0 0 1 16 5.37v.255a2.375 2.375 0 0 1-4.25 1.458A2.371 2.371 0 0 1 9.875 8 2.37 2.37 0 0 1 8 7.083 2.37 2.37 0 0 1 6.125 8a2.37 2.37 0 0 1-1.875-.917A2.375 2.375 0 0 1 0 5.625V5.37a1.5 1.5 0 0 1 .361-.976l2.61-3.045zm1.78 4.275a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0 1.375 1.375 0 1 0 2.75 0V5.37a.5.5 0 0 0-.12-.325L12.27 2H3.73L1.12 5.045A.5.5 0 0 0 1 5.37v.255a1.375 1.375 0 0 0 2.75 0 .5.5 0 0 1 1 0zM1.5 8.5A.5.5 0 0 1 2 9v6h12V9a.5.5 0 0 1 1 0v6h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1V9a.5.5 0 0 1 .5-.5zm2 .5a.5.5 0 0 1 .5.5V13h8V9.5a.5.5 0 0 1 1 0V13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5a.5.5 0 0 1 .5-.5z" />
                                </svg>
                                Kênh bán hàng
                            </a> --}}
                        </li>
                        </center>

                       
                    </ul>
                </div>
            </div>
            </div>
        </nav><br />
        <br /><br />                                                 
    