@extends('layouts.app')
@section('content')
    <h1>chào nhé, xin gửi món quà</h1>
    <h2>{{$title}}</h2>
    <?php
    foreach ($list as $value) {
        ?>
        <h2>{{$value}}</h2>
        <?php 
    }
    ?>

    @foreach($list as $value)
        <h1>value: {{ $value }}</h1>
    @endforeach
    <a href="{{ route('product') }}"> đi đến product index</a>
    {{
    
        $x = !empty($_GET['x']) ? $_GET['x']:2;
    }}
    @if($x>2)
        <h3> {{$x}} lớn hơn 2 </h3>
    @elseif($x<2)
        <h3> {{$x}} nhỏ hơn 2 </h3>
    @else
        <h3> {{$x}} bằng 2 </h3>
    @endif
    {{-- unless = "if not" --}}
    @unless (empty($x))
        <h3>x tồn tại</h3>
    @endunless
    @empty($name)
        <h4>name rổng</h4>
    @endempty
    @isset($name)
        <h3>name không rổng</h3>
    @endisset
    @switch($name)
        @case('dat')
            <h4>đây là đạt</h4>
            @break
        @case('chau')
            <h4>đây là châu</h4>
            @break
        @default
            <h3>KHông tìm thấy tên này</h3>
    @endswitch\
    @forelse ($collection as $item)
        <h2>{{ $item }}</h2>
    @empty
        <h4>list rổng</h4>
    @endforelse
    {{-- @while ()
        
    @endwhile --}}
@endsection