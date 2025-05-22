@extends('layouts.app')
@section('title', $artikel->judul)
{{-- <link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/96x96.png" sizes="96x96">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/120x120.png" sizes="120x120">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/152x152.png" sizes="152x152">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/167x167.png" sizes="167x167">
<link rel="apple-touch-icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/180x180.png" sizes="180x180"> --}}
<link rel="stylesheet" href="{{asset('ckeditor/style.css')}}">
<link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" crossorigin>
<link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
@push('style')
<style>
    img{
        border-radius: 12px;
        object-fit: cover;
    }
    .container-artikel{
        max-width: 100vw;
        display: flex;
        flex-direction: column;
        padding-left: 28px;
        color: white;
        padding-right: 28px
    }

    .judul-artikel{
        max-width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
    }
    .thumbnail{
        max-width: 100%;
        object-fit: cover;
    }

    .thumbnail img{
        max-width: 100%;
        margin-bottom: 28px
    }

    .btn-kembali{
        text-decoration: none;
        color:black;
        background-color: greenyellow;
        width: fit-content;
        height: auto;
        padding: 18px;       
        border: 2px solid black;
        border-radius: 18px;
        box-shadow: 7px 7px black;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        margin-bottom: 28px
    }

    .btn-kembali:hover{
        background-color: white;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }

    .ck-content img {
    max-width: 100%;
    height: auto;
    }

    .ck-content {
    display: block;
    line-height: 1.6;
    }

    .ck-content figure {
    margin: 1em 0;
    display: flex;
    align-items: flex-start;
    gap: 1em;
    }

    .ck-content figure img {
    max-width: 300px;
    height: auto;
    }

    .ck-content p {
    margin: 0 0 1em 0;
    }


</style>
@endpush


@section('content')

<div class="container-artikel">
    <div class="judul-artikel">
        <h2>{{ $artikel->judul }}</h2>
        <p>oleh TKDW LAMONG | {{$artikel->created_at}}</p>
    </div>
    <div class="thumbnail">
        @if($artikel->thumbnail)
            <img src="{{asset('storage/' . $artikel->thumbnail)}}" alt="" class="img-artikel">
        @endif
    </div>
    <div class="ck-content" style="margin-bottom: 28px">
        {!! $artikel->konten !!}
    </div>

    @guest
    <a href="{{route('listArtikel')}}" class="btn-kembali"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
      </svg> Kembali</a>
    @endguest

    @role('orangtua')
    <a href="{{route('listArtikel')}}" class="btn-kembali"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
      </svg> Kembali</a>
    @endrole

    @role('guru')
    <a href="{{route('artikel.index')}}" class="btn-kembali"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
      </svg> Kembali</a>
    @endrole
</div>
