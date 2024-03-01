@extends('layouts.setup')
@section('main')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/library/sidebar-manager.css') }}" rel="stylesheet">
    @php
        $user = Auth::user();            
        if(!isset($user))   
            $user = Auth::guard("admin-api")->user(); 
    @endphp
   
</head>
{{-- {{dd($user->getRouteInterfaces())}} --}}
<body >   

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="/" class="logo">
            <i class='bx bx-code-alt'></i>
            <div class="logo-name"><span>Linkien</span>Store</div>
        </a> 
        @yield("menu")              
        <ul class="side-menu p-0">
            <li>
                <a href="{{route("logout")}}" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->
    
    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form >
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>         
            <script src="{{asset('js/library/change-theme.js')}}"></script>    
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">12</span>
            </a>
            <a href="" class="profile">
                <img src="{{asset("img/user.png")}}">
                {{$user->HoVaTen ?? $user->TenNV ?? ""}}
            </a>
        </nav>         
        <main class="container">                          
            <section >
                @yield('content-main')
            </section>
        </main>   
    </div>
    @yield('mail')
<script src="{{asset('js/library/sidebar-manager.js')}}"></script>
</body>
</html>
@endsection