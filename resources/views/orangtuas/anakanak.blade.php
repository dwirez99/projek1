@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .card img {
            object-fit: cover;
            height: 100%;
            border-top-left-radius: 1rem;
            border-bottom-left-radius: 1rem;
        }
        .card-body p {
            margin-bottom: 0.3rem;
        }
        .header-bar h1 {
            color: #343a40;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    {{-- Pencarian --}}
    <div class="header-bar d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-2 mb-md-0">Daftar Peserta Didik</h1>
    </div>

    


    <!-- Tampilkan Peserta Didik -->
    <div class="row">
        @forelse ($anakanaks as $pd)
            <div class="col-md-6 mb-4">
                <div class="card overflow-hidden" x-data="{ edit: false }">
                    <div class="row g-0 h-100">
                        <div class="col-md-4">
                            <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : asset('default.jpg') }}" class="img-fluid h-100" alt="Foto Siswa">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $pd->namapd }}</h5>
                                <p>Orang Tua: {{ $pd->orangtua->namaortu }}</p>
                                <p>Lahir: {{ $pd->tanggallahir }}</p>
                                <p>Jenis Kelamin: {{ $pd->jeniskelamin }}</p>
                                <p>Kelas: {{ $pd->kelas }}</p>
                                <p>Tahun Ajar: {{ $pd->tahunajar }}</p>
                                <p>Semester: {{ $pd->semester }}</p>
                                <p>Tinggi Badan: {{ $pd->tinggibadan }} cm</p>
                                <p>Berat Badan: {{ $pd->beratbadan }} kg</p>
                                <p>Status Gizi: {{ $statusgizis[$pd->nisn]->status ?? 'Belum ada data' }}</p>

                                @if ($pd->file_penilaian)
                                    <a href="{{ asset('storage/' . $pd->file_penilaian) }}" target="_blank" class="btn btn-sm btn-primary mt-2">Lihat Penilaian</a>
                                @else
                                    <p class="text-muted mt-2">Belum ada dokumen diunggah</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">Tidak ada data siswa ditemukan.</p>
        @endforelse
    </div>
</div>
</body>
</html>
