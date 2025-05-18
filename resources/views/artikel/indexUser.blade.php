@extends('layouts.app')
@section('title', 'Daftar Kegiatan')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f4f4f4;
        font-family: "Poppins", sans-serif;
        margin: 0;
        padding: 0;
    }

    body::-webkit-scrollbar {
        display: none;
    }

    .judul-halaman {
        font-family: "Baloo Thambi 2", system-ui;
        font-size: 60px;
        color: #fff;
        background: linear-gradient(to right, #1c92d2, #f2fcfe);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        padding: 40px 50px;
        margin-bottom: 20px;
    }

    .container-artikel {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .card-artikel {
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: row;
        gap: 24px;
        padding: 20px;
    }

    .thumb-artikel {
        width: 250px;
        height: 160px;
        object-fit: cover;
        border-radius: 8px;
        flex-shrink: 0;
    }

    .konten-artikel {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
    }

    .judul-artikel {
        font-size: 22px;
        font-weight: 700;
        margin: 0 0 8px 0;
        color: #222;
    }

    .artikel-meta {
        font-size: 14px;
        color: #888;
        margin-bottom: 12px;
    }

    .deskripsi-artikel {
        font-size: 16px;
        color: #444;
        margin-bottom: 16px;
    }

    .btn-selengkapnya {
        align-self: flex-start;
        text-decoration: none;
        background-color: #007BFF;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: background-color 0.3s ease;
    }

    .btn-selengkapnya:hover {
        background-color: #0056b3;
    }
</style>

@section('content')
    <div class="judul-halaman">
        Daftar Kegiatan
    </div>

    <div class="container-artikel">
        @foreach($artikels as $artikel)
        <div class="card-artikel">
            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" class="thumb-artikel" alt="Thumbnail Artikel">
            <div class="konten-artikel">
                <div>
                    <h2 class="judul-artikel">{{ $artikel->judul }}</h2>
                    <p class="artikel-meta">Oleh TKDW Lamong | {{ $artikel->created_at->format('d M Y') }}</p>
                    <p class="deskripsi-artikel">{!! Str::limit(strip_tags($artikel->konten), 150) !!}</p>
                </div>
                <a href="{{ route('artikel.show', $artikel->id) }}" class="btn-selengkapnya">Baca Selengkapnya</a>
            </div>
        </div>
        @endforeach
    </div>
@endsection
