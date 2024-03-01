@extends('layouts.app')
@section('content')
<style>
  .error-validate{
    color: red;
    position: absolute;
  }
</style>
<!-- <link href="{{ asset('css/home/login.css') }}" rel="stylesheet"> -->
<!-- Section: Design Block -->
<section class="vh-100" style="">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col col-xl-10">
        <div class="card" style="border-radius: 1rem;">
          <div class="row g-0">
            <div class="col-md-6 col-lg-5 d-none d-md-block">
              <img src="https://media.vneconomy.vn/w800/images/upload/2022/05/23/ed4e5d5c-abed-44f4-902b-2b7f7d22799b.jpg"
                alt="login form" class="img-fluid h-100" style="border-radius: 1rem 0 0 1rem;" />
            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">

                <form method="post" id="form-login">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <i class='bx bxl-graphql' ></i>
                    <span class="h1 fw-bold mb-0">LinKienStore</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Đăng nhập</h5>

                  <div class="form-outline mb-4">
                    <input type="text" id="fieldvalue" name="fieldvalue" placeholder="Email, số điện thoại hoặc tên đăng nhập" class="form-control form-control-lg" required />
                    <!-- <label class="form-label" for="form2Example17">User name</label> -->
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" placeholder="Mật khẩu" name="password" id="form2Example27" class="form-control form-control-lg" required />
                    <!-- <label class="form-label" for="form2Example27">Password</label> -->
                    <span class="error-validate" id="error-validate"></span>
                  </div>
                  <div class="form-outline mb-4">
                    <input type="checkbox" placeholder="Mật khẩu" name="login_admin" id="login-admin"/>
                    <label class="form-label" for="login-admin">Đăng nhập admin</label>
                    <span class="error-validate" id="error-validate"></span>
                  </div>
                  <div class="pt-1 mb-4">
                    <button class="btn btn-warning btn-lg btn-block w-100" type="submit">Đăng nhập</button>
                  </div>

                  <a class="small text-muted" href="#!">Quên mật khẩu?</a>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Bạn chưa có tài khoản? <a href="/auth/register"
                      style="color: #393f81;">Đăng ký ngay</a></p>
                  {{-- <a href="#!" class="small text-muted">Terms of use.</a>
                  <a href="#!" class="small text-muted">Privacy policy</a> --}}
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="{{ asset('js/callapi/home/login.js') }}"></script>
<script src="{{ asset('js/handle/home/login.js') }}"></script>
@endsection