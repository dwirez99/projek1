@extends('layouts.app')

@section('content')
    <h2>Tambah Akun Orang Tua</h2>

    <form method="POST" action="{{ route('orangtua.store') }}">
        @csrf

        <label>Nama Lengkap</label>
        <input type="text" name="namaortu" value="{{ old('name') }}" required>
        @error('name')<div>{{ $message }}</div>@enderror

        <label>Nama Panggilan</label>
        <input type="text" name="nickname" value="{{ old('nickname') }}" required>
        @error('nickname')<div>{{ $message }}</div>@enderror

        <label>No Telepon</label>
        <input type="text" name="notelportu" value="{{ old('notelportu') }}" required>
        @error('notelportu')<div>{{ $message }}</div>@enderror

        <label>Alamat Rumah</label>
        <textarea name="alamat">{{ old('alamat') }}</textarea>

        <button type="submit">Simpan</button>
    </form>
@endsection
