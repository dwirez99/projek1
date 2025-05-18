@extends('layouts.app')

@push('head')
    <link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="https://ckeditor.com/assets/images/favicons/96x96.png" sizes="96x96">
    <link rel="apple-touch-icon" href="https://ckeditor.com/assets/images/favicons/180x180.png">
    <link rel="stylesheet" href="{{ asset('ckeditor/style.css') }}">
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/45.0.0/ckeditor5.css" crossorigin>
@endpush

@push('style')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f9f9f9;
        color: #333;
    }

    .container-artikel {
        max-width: 800px;
        margin: 40px auto;
        padding: 0 24px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .judul-artikel h2 {
        font-size: 32px;
        font-weight: 700;
        margin-top: 24px;
    }

    .judul-artikel p {
        color: #888;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .thumbnail img {
        width: 100%;
        border-radius: 12px;
        object-fit: cover;
        margin-bottom: 24px;
    }

    .ck-content {
        line-height: 1.8;
        font-size: 16px;
        color: #444;
        margin-bottom: 32px;
    }

    .ck-content img {
        max-width: 100%;
        border-radius: 8px;
    }

    .btn-kembali {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 20px;
        font-size: 16px;
        background-color: #00c853;
        color: #fff;
        border: none;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        margin-bottom: 32px;
    }

    .btn-kembali:hover {
        background-color: #00e676;
        transform: translateY(-3px);
    }

    .btn-kembali svg {
        margin-right: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-artikel">
    <div class="judul-artikel">
        <h2>{{ $artikel->judul }}</h2>
        <p>oleh TKDW LAMONG | {{ $artikel->created_at->format('d M Y') }}</p>
    </div>

    @if($artikel->thumbnail)
    <div class="thumbnail">
        <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="Thumbnail Artikel">
    </div>
    @endif

    <div class="ck-content">
        {!! $artikel->konten !!}
    </div>

    @guest
    <a href="{{ route('listArtikel') }}" class="btn-kembali">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
        </svg> Kembali
    </a>
    @endguest

    @role('orangtua')
    <a href="{{ route('listArtikel') }}" class="btn-kembali">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
        </svg> Kembali
    </a>
    @endrole

    @role('guru')
    <a href="{{ route('artikel.index') }}" class="btn-kembali">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
        </svg> Kembali
    </a>
    @endrole
</div>
@endsection
