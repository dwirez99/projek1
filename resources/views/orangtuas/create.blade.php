@extends('layouts.app')
@section('content')
@section('title','Tambah Akun Orang Tua')
<div class="container mt-4" style="padding-bottom: 100px;">
    <h2 class="mb-4" id="tag2">Tambah Akun Orang Tua</h2>

    <form method="POST" action="{{ route('orangtua.store') }}" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="namaortu" class="form-label">Nama Lengkap</label>
            <input type="text" name="namaortu" id="namaortu" class="form-control @error('namaortu') is-invalid @enderror" value="{{ old('namaortu') }}" required>
            @error('namaortu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nickname" class="form-label">Nama Panggilan</label>
            <input type="text" name="nickname" id="nickname" class="form-control @error('nickname') is-invalid @enderror" value="{{ old('nickname') }}" required>
            @error('nickname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="notelportu" class="form-label">No Telepon</label>
            <input type="text" name="notelportu" id="notelportu" class="form-control @error('notelportu') is-invalid @enderror" value="{{ old('notelportu') }}" required>
            @error('notelportu')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat Rumah</label>
            <textarea name="alamat" id="alamat" class="form-control" rows="3">{{ old('alamat') }}</textarea>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection
