@extends('layouts.app')
@section('title', 'Kelola Artikel')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        background-color: #f9f9f9;
        font-family: 'Poppins', sans-serif;
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

    .btn-container {
        display: flex;
        justify-content: flex-start;
        padding: 20px 60px;
        gap: 16px;
    }

    .btn-tambah {
        background-color: #28a745;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        box-shadow: 4px 4px #1e7e34;
        text-decoration: none;
        transition: 0.2s ease-in-out;
    }

    .btn-tambah:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .container-artikel {
        padding: 20px 60px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .card-artikel {
        background-color: white;
        border-radius: 12px;
        display: flex;
        flex-wrap: wrap;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        gap: 20px;
    }

    .thumb-artikel {
        width: 200px;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
    }

    .heading-artikel {
        flex: 1;
    }

    .judul-artikel {
        font-family: "Newsreader", serif;
        font-size: 22px;
        font-weight: 700;
        color: #222;
        margin: 0 0 10px 0;
    }

    .konten-artikel {
        flex: 1 1 100%;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 10px;
    }

    .btn-selengkapnya {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
        transition: 0.2s;
    }

    .btn-selengkapnya:hover {
        text-decoration: underline;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
    }

    .btn-edit,
    .btn-hapus {
        padding: 10px 18px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        box-shadow: 3px 3px #555;
        text-decoration: none;
        color: black;
        transition: 0.2s ease-in-out;
    }

    .btn-edit {
        background-color: #ffc107;
    }

    .btn-edit:hover {
        background-color: #e0a800;
        transform: translateY(-2px);
    }

    .btn-hapus {
        background-color: #dc3545;
        color: white;
    }

    .btn-hapus:hover {
        background-color: #c82333;
        transform: translateY(-2px);
    }

    .created-by {
        font-size: 14px;
        color: #666;
        margin-top: -8px;
    }
</style>

@section('content')

<div class="judul-halaman">
        Daftar Kegiatan
    </div>

<div class="btn-container">
    <a href="{{ route('artikel.create') }}" class="btn-tambah">+ Tambah Artikel</a>
</div>

<div class="container-artikel">
    @foreach($artikels as $artikel)
    <div class="card-artikel">
        <img src="{{ asset('storage/' . $artikel->thumbnail) }}" alt="Thumbnail" class="thumb-artikel">

        <div class="heading-artikel">
            <h5 class="judul-artikel">{{ $artikel->judul }}</h5>
            <p class="created-by">Oleh TKDW Lamong | {{ $artikel->created_at->format('d M Y') }}</p>
        </div>

        <div class="konten-artikel">
            <a href="{{ route('artikel.show', $artikel->id) }}" class="btn-selengkapnya">Lihat Selengkapnya</a>
            <div class="action-buttons">
                <a href="{{ route('artikel.edit', $artikel->id) }}" class="btn-edit">Edit</a>
                <form action="{{ route('artikel.destroy', $artikel->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')" style="display: inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-hapus">Hapus</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
