<link href="{{ asset('css/library/bootstrap.css') }}" rel="stylesheet">
<script src="{{ asset('js/library/bootstrap.js') }}"></script>
{{-- <style>
    .box-shadow{
        background-color: var(--bs-light);
        border-radius: 10px;
        box-shadow: 1px 4px 10px #AAAAAA;
    }
    .box-white{        
        background-color: var(--bs-light);
        border-radius: 10px;
    }
    .page-item{        
        cursor: pointer;
    }
    input[type="checkbox"]:checked{
            background-color: rgb(255, 166, 0)!important;
            box-shadow: 1px 1px 2px rgb(255, 166, 0);
            border: 1px solid #fb7500;
        }
    select option:hover {
        background-color: rgb(255, 166, 0)!important;
        color: #000; /* Màu chữ cho tùy chọn đã chọn */
    }
    .border-error{
        border-color: red !important;
    }
    input{
        color: var(--bs-light-text-emphasis);
    }
    *{
        color: var(--bs-light-text-emphasis);
    }  
    i{
        color: var(--bs-light-text-emphasis) !important;
    } 
</style> --}}

<!-- {{-- <script src="https://kit.fontawesome.com/213b585f79.js" crossorigin="anonymous"></script> --}} -->
<!-- Jquery -->
<script rel="stylesheet" src="{{ asset('js/library/jquery.min.js') }}"></script>

<!--toastMessage-->
<link rel="stylesheet" href="{{asset('css/library/toastmessage.css')}}" />    
<link rel="stylesheet" href="{{asset('css/library/message-box.css')}}" />  

<link href="{{ asset('css/library/enter_quantity.css') }}" rel="stylesheet">

<!--config setup-->
<script  rel="stylesheet" src="{{asset('js/config/config.js')}}"></script>

<!--pagination-->
<script  rel="stylesheet" src="{{asset('js/library/pagination.js')}}"></script>

<!--Message Box-->
<script src="{{asset('js/library/message-box.js')}}"></script>
<!--Helper-->
<script src="{{asset('js/library/helper.js')}}"></script>
<script src="{{asset('js/library/buildfontendrestfullapi.js')}}"></script>

<!--Icon-->
{{-- <script src="https://unpkg.com/@phosphor-icons/web"></script> --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

<style>
    .box-white{        
        background-color: var(--bs-light);
        border-radius: 5px;
    }    
    .box-info{
        min-height: 600px;
        padding: 20px;
        position: relative;
    }
    .box-information-input{
        position: relative;
        padding: 20px 10px;
    }
    .information-label{
        position: absolute;
        background: var(--bs-body-bg);
        top: 7;
        left: 20px;
        padding: 0 5;   
        cursor: pointer; 
        border-radius: 5px; 
    }
    .information-input{
        width: 100%;
        text-align: center;
        height: 45px;
        border-radius:5px;
        border: 1px solid black; 
        cursor: default;   
        background-color: var(--bs-body-bg); 
    }
    .information-input.text-left{
        padding: 0 10px; 
        text-align: left;
    }
    .error-information{
        font-size: 13px;
        color: red;
        position: absolute;
        bottom: 0;
        left: 11;
        display: none;
    }
    .information-input.error-information-input{
        border: 1px solid red;
    }
    input.information-input-hover:hover{
        border: 1px solid #f7b500;
        cursor: auto;     
    }
    .information-input:focus{
        border: 1px solid #f7b500;     
    }
    div.information-input{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10%;
    }
    .information-input.information-input-don-hover:hover{
        border: 1px solid black; 
    }
    .item-gender{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 3px;
    }
    .box-image-avatar{
        position: relative;
    }
    .image-avatar{    
        display: block;
        width: 100%;
        height: 300px;
        border-left:1px solid var(--bs-light-text-emphasis);   
        border-right:1px solid var(--bs-light-text-emphasis);  
        border-top:1px solid var(--bs-light-text-emphasis);   
    }
    .information-title{
        color:#f7b500;
        background-color: black;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 10px;
        font-size: 17px;
    }
    #input-joining-date{
        cursor: default;
    }
    .box-account-link{
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;    
    }
    .box-button{
        padding: 20px 30px;
        position: absolute;
        bottom: 0;
    }
    .btn-update{
        float: right;
        width: 110px;
    }
    .box-btn-choose-avatar{
        position: relative;
        display: flex;
        justify-content: center;
        cursor: pointer;
    }
    .btn-update-avatar{
        width: 100%;
        font-size:17px;
        background-color: #f7cf62;
        color: black;
        border-bottom-left-radius: 5px;  
        border-bottom-right-radius: 5px;  
        border-left: 1px solid black;
        border-right: 1px solid black;
        border-bottom: 1px solid black;
        border-top:none;
        padding: 5px 10px;
    }
    .information-input-hover:hover{
        border: 1px solid #f7b500;     
    }
    .box-drop-drag-avatar{
        width: 100%;
        border: 3px dashed #f7b500;
        border-radius: 10px;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        overflow: hidden;
        position: relative;
    }
    .title-choose-avatar{
        width: 100%;
        text-align: center;
        color: var(--bs-light-text-emphasis);   
    }
    #btn-choose-avatar{
        padding: 5px 10px;
        width: 100px;
        border-radius: 5px;
        background-color: #f7b500;    
    }
    .box-operation-choose-avatar{
        margin: 10 0;
        min-height: 70px;
    }
    .box-show-avatar{    
        top: 0;    
        min-width:100%; 
        height: 100%;          
    }
    .avatar-preview{
        border-top-left-radius:5px; 
        border-top-right-radius:5px; 
        height: 100%;    
    }
    .box-image-avatar{
        border-right: 1px solid #000; 
        border-bottom: 1px solid #000;  
        border-left: 1px solid #000;  
        margin-left:12px;  
        border-bottom-left-radius: 5px;      
        border-bottom-right-radius: 5px;      
    }
    .item-image-avatar{        
        padding-top:10px; 
        padding-bottom:10px;
        color: crimson; 
    }
    .item-remove-avatar{
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        opacity: 0;
    }
    .image-avatar:hover .item-remove-avatar{
        opacity: 1;
    }
    @media (max-width:991px){ 
        .box-button{
            position: sticky;
            width: 100%;     
            bottom: 0px;        
        }   
        .btn-update{
            background-color: var(--bs-light-text-emphasis);
        }
    }
    @media (max-width:767px){
        .item-image-avatar{
            padding: 0;
        }
        .box-image-avatar{
            border: none;
            margin:0;
        }
        .item-remove-avatar{
            right: 12px;
            top: 1px;
        }    
    }
    .btn-update-password{
            position: absolute;
            right: 10;
            border-right: none;
            border: 1px solid var(--bs-light-text-emphasis);
            border-radius:5px; 
            background-color: var(--bs-light);
            opacity: 0;
            transition: all 0.3s;
            height: 45px;
        }
    .information-input:hover .btn-update-password{
        opacity: 1;      
        width: auto;
    }
    .btn-update-password:hover{
        border: 1px solid #f7b500;
    }
    .border-message{
            border: 1px solid red;        
        }
    .box-show-password{
        margin-left: 10px;
    }
</style>

<!-- ##### notifications ##### -->
<ul class="notifications"></ul>
@yield('main') 
<!-- Toastmessage -->
<script type="text/javascript" src="{{asset('js/library/toastmessage.js')}}"></script>   