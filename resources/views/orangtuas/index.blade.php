@extends('layouts.app')

@section('title','Daftar Orang Tua')

@section('content')
<div class="container mt-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <h1 class="fw-bold">Daftar Orang Tua</h1>
        <form action="{{ route('orangtua.index') }}" method="GET" class="d-flex gap-2 w-100 w-md-auto">
            <input type="text" name="cari" class="form-control rounded-pill shadow-sm" placeholder="Cari nama orang tua..." value="{{ request('cari') }}" style="max-width: 260px;">
            <button type="submit" class="btn btn-outline-primary rounded-pill shadow-sm">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="mb-4 text-end">
        <a href="{{ route('orangtua.create') }}" class="btn btn-success shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Orang Tua
        </a>
    </div>

    @if($orangtuas->isEmpty())
        <div class="alert alert-info text-center shadow-sm">Tidak ada data orang tua ditemukan.</div>
    @else
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($orangtuas as $ortu)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-shadow">
                        <div class="card-body">
                            <h5 class="card-title text-primary fw-bold">
                                <i class="bi bi-person-circle me-2"></i>{{ $ortu->namaortu }}
                            </h5>
                            <p class="mb-1"><span class="text-muted">Nickname:</span> {{ $ortu->nickname }}</p>
                            <p class="mb-1"><span class="text-muted">Email:</span> {{ $ortu->emailortu }}</p>
                            <p class="mb-1"><span class="text-muted">No. Telepon:</span> {{ $ortu->notelportu }}</p>
                            <p class="mb-0"><span class="text-muted">Alamat:</span> {{ $ortu->alamat }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-end gap-2">
                            {{-- <a href="{{ route('orangtua.edit', $ortu->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                            <form method="POST" action="{{ route('orangtua.destroy', $ortu->id) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination (aktifkan jika data banyak) --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $orangtuas->links() }}
        </div>
    @endif
</div>

{{-- Optional: smooth shadow on hover --}}
<style>
    .hover-shadow:hover {
        box-shadow: 0 0.5rem 1.25rem rgba(0, 0, 0, 0.1) !important;
        transition: all 0.3s ease-in-out;
    }
</style>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
