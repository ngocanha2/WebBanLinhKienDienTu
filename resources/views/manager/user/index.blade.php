@extends('layouts.layoutdashboard')
@section('content')
<style>
    .page-item{
        cursor: pointer;
    }
    .box-sort-by{
        float: left;
        margin: 0 20px; 
    }
</style>
<div class="left">
    <h1>Quản lý khách hàng</h1>
    <ul class="breadcrumb">
        {{-- <li><a href="#">
                Analytics
            </a></li>
        /
        <li><a href="#" class="active">Shop</a></li> --}}
    </ul>
</div>
<div>
    {{-- <div>    
        <label for="">per page</label>
        <input type="text" name="per_page">               
    </div> --}}
    <!-- <strong>Sort:</strong>
    <div>       
        <div class="box-sort-by">
            <strong>By Username</strong><br>
            <input type="radio" name="sort_username" value="1" id="sort-username-asc">   
            <label for="sort-username-asc">Asc</label>
            <input type="radio" name="sort_username" value="-1" id="sort-username-desc">
            <label for="sort-username-desc">Desc</label>
        </div>
        <div class="box-sort-by">
            <strong>By birthday</strong><br>
            <input type="radio" name="sort_birthday" value="1" id="sort-birthday-asc">   
            <label for="sort-birthday-asc">Asc</label>
            <input type="radio" name="sort_birthday" value="-1" id="sort-birthday-desc">
            <label for="sort-birthday-desc">Desc</label>
        </div>
        <div class="box-sort-by">
            <strong>By Create at</strong><br>
            <input type="radio" name="sort_created_at" value="1" id="sort-created-at-asc">   
            <label for="sort-created-at-asc">Asc</label>
            <input type="radio" name="sort_created_at" value="-1" id="sort-created-at-desc">
            <label for="sort-created-at-desc">Desc</label>
        </div>
        <div style="clear: both"></div>
        <div>
            <button class="btn btn-warning" id="btn-sort">sort</button>
        </div>
    </div>
    <br> -->    
    <div class="box-white p-4">
        <table class="table table-hover table-striped table-bordered" border="1">
            <thead>
                <tr>
                    <td></td>
                    <td>Mã</td>                    
                    <td>Tên đăng nhập</td>
                    <td>Họ và tên</td>
                    <td>Email</td>
                    <td>Số điện thoại</td>                
                    <td>Ngày sinh</td>
                    <td>Giới tính</td>
                    <td>Ngày Tạo</td>
                    <td></td>                                        
                </tr>
            </thead>
            <tbody id="table-users-body">
                {{-- @foreach ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->full_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone_number}}</td>
                    <td>{{$user->date_of_birth}}</td>
                    <td>{{$user->getStatus()}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$now}}</td>
                    
                </tr>
                @endforeach --}}
            </tbody>
        </table>
        <center> <ul class="pagination" id="pagination" style="clear: both">  </center>
    </div>
</div>
<script src="{{asset("js/handle/manager/user/index.js")}}"></script>
@endsection


