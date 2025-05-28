@extends('layouts.app')

@section('title', 'Profil Orang Tua')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold mb-4">Profil Orang Tua</h1>

    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm p-4">
        <div class="mb-3">
            <label class="form-label fw-bold">Nama Lengkap:</label>
            <div>{{ $orangtua->namaortu ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nama Panggilan (Username):</label>
            <div>{{ $orangtua->nickname ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Email:</label>
            <div>{{ $orangtua->emailortu ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Nomor Telepon:</label>
            <div>{{ $orangtua->notelportu ?? '-' }}</div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Alamat:</label>
            <div>{{ $user->alamat ?? '-' }}</div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('home') }}" class="btn btn-secondary">← Kembali ke Beranda</a>
            <a href="{{ route('editprofiles') }}" class="btn btn-primary">Edit Profil</a>
        </div>
    </div>
</div>
@endsection
