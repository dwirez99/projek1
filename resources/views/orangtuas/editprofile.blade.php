@extends('layouts.app')

@section('title', 'Profil Orang Tua')

@section('content')
<div class="container mt-5">
    <h1 class="fw-bold mb-4">Profil Orang Tua</h1>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('editprofiles.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="namaortu" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('namaortu') is-invalid @enderror" id="namaortu" name="namaortu" value="{{ old('namaortu', $orangtua->namaortu) }}" required>
                    @error('namaortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="nickname" class="form-label">Nama Panggilan (Username)</label>
                    <input type="text" class="form-control @error('nickname') is-invalid @enderror" id="nickname" name="nickname" value="{{ old('nickname', $orangtua->nickname) }}" required>
                    @error('nickname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="emailortu" class="form-label">Email</label>
                    <input type="email" class="form-control @error('emailortu') is-invalid @enderror" id="emailortu" name="emailortu" value="{{ old('emailortu', $orangtua->emailortu) }}" required>
                    @error('emailortu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (kosongkan jika tidak diganti)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $user->alamat) }}">
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="notelportu" class="form-label">Nomor Telepon</label>
                    <input type="text" class="form-control @error('notelportu') is-invalid @enderror" id="notelportu" name="notelportu" value="{{ old('notelportu', $orangtua->notelportu) }}" required>
                    @error('notelportu')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


