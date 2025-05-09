@extends('layouts.app')

@push('style')
<style>
    img{
        border-radius: 12px
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

    .konten-artikel{
        max-width: 100%;
        display: flex;
        flex-wrap: wrap;
        font-family: "Poppins", sans-serif;
    }

    .konten-artikel img{
        max-width: 100%;
        object-fit: cover;

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
    <div class="konten-artikel">
        <p>{!! $artikel->konten !!}</p>
    </div>
    <a href="{{route('artikel.index')}}" class="btn-kembali"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
      </svg> Kembali</a>
</div>

