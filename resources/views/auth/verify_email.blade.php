@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verify Email</title>


    <script type="text/javascript" src="{{asset('js/callapi/auth/verify_email.js')}}"></script>

</head>
<body>
    <div class="container" >
        <br>
        <br>
        <br>
        <br>
        <br>
        <div id="box-show-result-verify-email" style="min-height: 500px">
            <script type="text/javascript" src="{{asset('js/handle/auth/verify_email.js')}}"></script>
            <script>
                verifyEmail('{{$id}}','{{$token}}')
            </script>
        </div>        
    </div>
</body>
</html>
@endsection