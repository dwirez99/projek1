@extends('layouts.app')
@section('title','Daftar Guru')

@section('content')
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
