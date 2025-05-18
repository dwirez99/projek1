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
</head>
<body>
<div class="container mt-4">
    {{-- Pencarian --}}
    <div class="header-bar d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-2 mb-md-0" style="color: white">Daftar Peserta Didik</h1>
    </div>

    <!-- Tampilkan Peserta Didik -->
    <div class="row">
        @forelse ($anakanaks as $pd)
            <div class="col-md-6 mb-4">
                <div class="card" x-data="{ edit: false }">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : asset('default.jpg') }}" class="img-fluid rounded-start" alt="Foto Siswa">
                        </div>
                        <div class="col-md-8">
                                <div class="card-body">
                                        <div>
                                            <h5 class="card-title">{{ $pd->namapd }}</h5>
                                            <p class="card-text">
                                                Orang Tua: {{ $pd->orangtua->namaortu }}<br>
                                            </p>
                                            <p style="margin: 0">
                                                Lahir: {{ $pd->tanggallahir }}
                                            </p>
                                            <p style="margin: 0">
                                                Jenis Kelamin: {{ $pd->jeniskelamin }}
                                            </p>
                                            <p style="margin: 0">
                                                Kelas: {{ $pd->kelas }}
                                            </p>
                                            <p style="margin: 0">
                                                Tahun Ajar: {{ $pd->tahunajar }}
                                            </p>
                                            <p style="margin: 0">
                                                Semester: {{ $pd->semester }}
                                            </p>
                                            <p style="margin: 0">
                                                Tinggi Badan: {{ $pd->tinggibadan }} cm
                                            </p>
                                            <p style="margin: 0">
                                                Berat Badan: {{ $pd->beratbadan }} kg
                                            </p>
                                            <p style="margin: 0">
                                                Status Gizi: {{ $statusgizis[$pd->nisn]->status ?? 'Belum ada data' }}
                                            </p>
                                            <p style="margin: 0">
                                                Nilai: <a href="#">Masukkan Nilai per siswa disini</a>
                                            </p>
                                            
                                        </div>
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

