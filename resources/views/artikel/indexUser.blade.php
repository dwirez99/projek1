@extends('layouts.app')
<title>Daftar Kegiatan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
    body::-webkit-scrollbar{
        display: none
    }
    .judul-halaman{
        font-family: "Baloo Thambi 2", system-ui;
        font-optical-sizing: auto;
        font-weight: 700;
        font-style: normal;
        font-size:80px;
        color: aliceblue;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        padding-left: 50px;
        min-width: 100vw;
    }

    .btn-container{
        margin: 28px;
        padding: 12px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        gap: 28px;
    }
    .btn-tambah{
        text-decoration: none;
        color:black;
        background-color: greenyellow;
        width: auto;
        height: auto;
        padding: 18px;
        text-align: center;
        border: 2px solid black;
        border-radius: 18px;
        box-shadow: 7px 7px black;
        margin: 28px;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        margin: auto;
    }

    .btn-tambah:hover{
        background-color: white;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .container-artikel{
        display: flex;
        justify-content: flex-start;
        align-content: center;
        min-width: 100vw;
        flex-wrap: wrap;
        padding: 28px;
        gap: 18px;
        flex-direction: column;
    }

    .card-artikel{
        background-color: white;
        display: flex;
        min-width: 100%;
        flex-wrap: wrap;
        padding: 18px;
        border-radius: 14px;
        gap: 18px;

    }

    .thumb-artikel{
        max-width: 100%;
        object-fit: cover;
        border-radius: 7px;
    }
    .konten-artikel{
        max-width: 100%;
        display: flex;
        flex-wrap: wrap;
        font-family: "Poppins", sans-serif;
        font-size: 16px
    }
    .judul-artikel{
        min-width: 100%;
        font-family: "Baloo Thambi 2", system-ui;
        font-size: 28px;
    }
    .deskripsi-artikel{
        display: flex;
        width: 1200px;
        max-width: 100%;
        word-wrap: break-word;
        flex-wrap: wrap;
    }

    .btn-edit{
        text-decoration: none;
        color:black;
        background-color: yellow;
        width: auto;
        height: auto;
        padding: 18px;
        text-align: center;
        border: 2px solid black;
        border-radius: 18px;
        box-shadow: 7px 7px black;
        margin: 28px;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        margin: auto;
    }

    .btn-edit:hover{
        background-color: white;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .btn-hapus{
        text-decoration: none;
        color:black;
        background-color: red;
        width: auto;
        height: auto;
        padding: 18px;
        text-align: center;
        border: 2px solid black;
        border-radius: 18px;
        box-shadow: 7px 7px black;
        margin: 28px;
        font-family: "Poppins", sans-serif;
        font-size: 18px;
        margin: auto;
    }

    .btn-hapus:hover{
        background-color: white;
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    .heading-artikel{
        min-width: 100%;
    }


</style>

    @section('content')
    <div class="judul-halaman">
        <h4 class="judul-halaman">Daftar Kegiatan</h4>
    </div>

    <div class="container-artikel">
        @foreach($artikels as $artikel)
        <div class="card-artikel">
            <img src="{{asset('storage/' . $artikel->thumbnail)}}" class="thumb-artikel" alt="Thumbnail">
            <div class="heading-artikel">
                <h5 class="judul-artikel">{{ $artikel->judul }}<br></h5>
                <p>Oleh TKDW Lamong | {{ $artikel->created_at }}</p>
            </div>
            <div class="konten-artikel">
                {{-- <div class="deskripsi-artikel">
                    {!! Str::limit($artikel->konten, 100) !!}
                </div> --}}
                <a href="{{ route('artikel.show', $artikel->id)}}" class="btn-selengkapnya" style="min-width: 100%">Selengkapnya</a>
                
            </div>
        </div>
        @endforeach
    </div>
@endsection