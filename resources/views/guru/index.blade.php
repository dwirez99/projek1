@extends('layouts.app')
@section('title','Daftar Guru')
<link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>

.judul-halaman {
        font-family: "Baloo Thambi 2", system-ui;
        font-size: 60px;
        color: #fff;
        background: linear-gradient(to right, #1c92d2, #f2fcfe);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        padding: 40px 50px;
        margin-bottom: 20px;
    }
</style>

@section('content')
<div class="judul-halaman">
    Daftar Guru
</div>
<div class="container mx-auto px-5 py-8">

    <!-- Grid Guru -->
    <div class="row justify-content-center g-4">
        @forelse ($gurus as $guru)
        <div class="col-md-3 d-flex">
            <div class="card w-100 d-flex flex-column align-items-center p-3 shadow" style="border-radius: 20px; min-height: 380px;">
                <div class="w-100 d-flex justify-content-center mb-3">
                    <img src="{{ asset($guru->image) }}"
                         alt="{{ $guru->name }}"
                         class="img-fluid rounded"
                         style="width: 100%; aspect-ratio: 1/1; object-fit: cover; border-radius: 50px 30px 5px 20px;">
                </div>
                <div class="text-center mt-auto">
                    <h5 class="fw-bold mb-1">{{ $guru->name }}</h5>
                    <p class="text-muted">{{ $guru->position }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-lg text-muted">Tidak ada data guru ditemukan.</div>
        @endforelse
    </div>
</div>
@endsection
