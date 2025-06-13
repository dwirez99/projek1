@extends('layouts.app')

@section('title', $artikel->judul)

@push('style')
<style>
    .artikel-wrapper {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background-color: white;
        border-radius: 20px;
        box-shadow: 10px 10px 0px #000000;
        font-family: 'Poppins', sans-serif;
    }

    .artikel-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 16px;
    }

    .artikel-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .artikel-meta img {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
    }

    .artikel-meta-info {
        display: flex;
        flex-direction: column;
        font-size: 14px;
        color: #333;
    }

    .artikel-thumbnail img {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 16px;
        margin-bottom: 24px;
    }

    .artikel-content {
        font-size: 16px;
        line-height: 1.8;
        color: #222;
    }

    .btn-back {
        margin-top: 30px;
        display: inline-block;
        background-color: greenyellow;
        border: 2px solid #000;
        padding: 10px 18px;
        border-radius: 14px;
        font-weight: 600;
        color: #000;
        text-decoration: none;
        box-shadow: 6px 6px #000;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background-color: white;
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .artikel-wrapper {
            margin: 20px;
            padding: 20px;
        }

        .artikel-title {
            font-size: 1.8rem;
        }

        .artikel-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="artikel-wrapper">
    <h1 class="artikel-title">{{ $artikel->judul }}</h1>

    <div class="artikel-meta">
        <img src="{{ asset('build/assets/logo/logo_dw.png') }}" alt="Avatar Penulis">
        <div class="artikel-meta-info">
            <strong>TK DHARMA WANITA LAMONG</strong>
            <span>Guru</span>
            <span>Di Publikasikan: {{ $artikel->created_at->format('d-m-Y') }}</span>
        </div>
    </div>

    @if($artikel->thumbnail)
        <div class="artikel-thumbnail">
            <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="Thumbnail Artikel">
        </div>
    @endif

    <div class="artikel-content">
        {!! $artikel->konten !!}
    </div>

    <a href="{{ route('listArtikel') }}" class="btn-back">← Kembali</a>
</div>
@endsection
