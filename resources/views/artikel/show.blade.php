@extends('layouts.app')
@section('content')
<div class="container-artikel">
    <div class="judul-artikel">
        <h2>{{ $artikel->judul }}</h2>
    </div>
    <div class="thumbnail">
        @if($artikel->thumbnail)
            <img src="{{asset('storage/' . $artikel->thumbnail)}}" alt="" class="img-artikel">
        @endif
    </div>
    <div class="konten-artikel">
        <p>{!! $artikel->konten !!}</p>
    </div>
</div>

<a href="{{route('artikel.index')}}" class="btn-kembali"></a>