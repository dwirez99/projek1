@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="header-bar d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-2 mb-md-0">Daftar Orang Tua</h1>
        <form action="{{ route('orangtua.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="cari" class="form-control rounded-pill" placeholder="Cari nama orangtua..." value="{{ request('cari') }}" style="max-width: 200px;">
            <button type="submit" class="btn btn-light rounded-pill shadow-sm">Cari</button>
        </form>
    </div>

    <div class="mb-4">
        <a href="{{ route('orangtua.create') }}" class="btn btn-success">Tambah Orang Tua</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($orangtuas as $ortu)
            <div class="col-md-6 mb-4" x-data="{ edit: false }">
                <div class="card">
                    <form method="POST" action="{{ route('orangtua.update', $ortu->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="card-body">
                            <template x-if="!edit">
                                <div>
                                    <h5 class="card-title">{{ $ortu->namaortu }}</h5>
                                    <p class="card-text">{{ $ortu->nickname }}</p>
                                    <p class="card-text">
                                        Email: {{ $ortu->emailortu }}<br>
                                        Alamat: {{ $ortu->user->alamat }}<br>
                                        No. Telp: {{ $ortu->notelportu }}<br>
                                        Username: {{ $ortu->user->username }}<br>
                                    </p>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div>
                                    <div class="mb-2">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="namaortu" class="form-control" value="{{ $ortu->namaortu }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Nama Panggilan</label>
                                        <input type="text" name="nickname" class="form-control" value="{{ $ortu->nickname }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="emailortu" class="form-control" value="{{ $ortu->emailortu }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">No. Telp</label>
                                        <input type="text" name="notelportu" class="form-control" value="{{ $ortu->notelportu }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Alamat</label>
                                        <input type="text" name="alamat" class="form-control" value="{{ $ortu->user->alamat }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Username</label>
                                        <input type="text" name="username" class="form-control" value="{{ $ortu->user->username }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Isi jika ingin mengganti password">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label">Konfirmasi Password</label>
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi password baru">
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                                        <button type="button" class="btn btn-secondary btn-sm" @click="edit = false">Batal</button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </form>

                    <div class="card-footer d-flex justify-content-end gap-2">
                        <button class="btn btn-warning btn-sm" @click="edit = true">Edit</button>
                        <form method="POST" action="{{ route('orangtua.destroy', $ortu->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada data orang tua ditemukan.</p>
        @endforelse
    </div>

    {{-- <div class="d-flex justify-content-center">
        {{ $orangtuas->links() }}
    </div> --}}
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
