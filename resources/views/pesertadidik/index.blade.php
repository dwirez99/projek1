@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/style.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .list-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .list-item:hover {
            background-color: #f8f9fa;
            border-left-color: #0d6efd;
        }
        .student-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .student-info {
            flex: 1;
            min-width: 0; /* Untuk mencegah overflow */
        }
        .student-name {
            font-weight: 600;
            margin-bottom: 4px;
        }
        .student-detail {
            font-size: 0.875rem;
            color: #6c757d;
        }
        .action-buttons {
            white-space: nowrap;
        }
        .detail-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .detail-col {
            flex: 1;
            min-width: 120px;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    {{-- Header dan Pencarian --}}
    <div class="header-bar d-flex flex-wrap justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-2 mb-md-0">Daftar Siswa</h1>
        <form action="{{ route('pesertadidik.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="cari" class="form-control rounded-pill" placeholder="Cari nama siswa..." value="{{ request('cari') }}" style="max-width: 200px;">
            <button type="submit" class="btn btn-light rounded-pill shadow-sm">Cari</button>
        </form>
    </div>

    {{-- Tombol Tambah Data --}}
    <div class="text-left mb-4">
        <a href="{{ route('pesertadidik.create') }}" class="btn btn-success">Tambah Siswa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="list-group">
        @forelse ($pesertadidiks as $pd)
            <div class="list-group-item list-item mb-3 p-3" x-data="{ edit: false, showDetails: false }">
                <form method="POST" action="{{ route('pesertadidik.update', $pd->nisn) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="d-flex align-items-start gap-3">
                        {{-- Kolom Kiri: Foto --}}
                        <div>
                            <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : asset('default.jpg') }}"
                                 class="student-photo" alt="Foto Siswa">
                            <template x-if="edit">
                                <input type="file" name="foto" class="form-control form-control-sm mt-2" style="width: 80px;">
                            </template>
                        </div>

                        {{-- Kolom Kanan: Informasi --}}
                        <div class="student-info">
                            <template x-if="!edit">
                                <div>
                                    <div class="student-name">{{ $pd->namapd }} <small class="text-muted">(NISN: {{ $pd->nisn }})</small></div>
                                    <div class="student-detail mb-2">
                                        <div>Orang Tua: {{ $pd->orangtua->namaortu }} ({{ $pd->orangtua->nickname }})</div>
                                        <div>Lahir: {{ $pd->tanggallahir }} | {{ $pd->jeniskelamin }}</div>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-secondary mb-2"
                                            @click="showDetails = !showDetails">
                                        <span x-text="showDetails ? 'Sembunyikan' : 'Lihat'">Lihat</span> Detail
                                    </button>

                                    <div class="detail-row" x-show="showDetails" x-transition>
                                        <div class="detail-col">
                                            <div><strong>Kelas:</strong> {{ $pd->kelas }}</div>
                                            <div><strong>Tahun Ajar:</strong> {{ $pd->tahunajar }}</div>
                                        </div>
                                        <div class="detail-col">
                                            <div><strong>Semester:</strong> {{ $pd->semester }}</div>
                                            <div><strong>TB/BB:</strong> {{ $pd->tinggibadan }} cm / {{ $pd->beratbadan }} kg</div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div>
                                    <div class="mb-2">
                                        <input type="text" name="namapd" value="{{ $pd->namapd }}" class="form-control form-control-sm" placeholder="Nama Siswa">
                                    </div>
                                    <div class="detail-row mb-2">
                                        <div class="detail-col">
                                            <select name="idortu" class="form-select form-select-sm mb-2">
                                                @foreach ($orangtuas as $ortu)
                                                    <option value="{{ $ortu->id }}" {{ $ortu->id == $pd->idortu ? 'selected' : '' }}>
                                                        {{ $ortu->namaortu }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="date" name="tanggallahir" value="{{ $pd->tanggallahir }}" class="form-control form-control-sm">
                                        </div>
                                        <div class="detail-col">
                                            <select name="jeniskelamin" class="form-select form-select-sm mb-2">
                                                <option value="Laki-laki" {{ $pd->jeniskelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $pd->jeniskelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            <input type="text" name="kelas" value="{{ $pd->kelas }}" class="form-control form-control-sm" placeholder="Kelas">
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-col">
                                            <input type="text" name="tahunajar" value="{{ $pd->tahunajar }}" class="form-control form-control-sm mb-2" placeholder="Tahun Ajar">
                                        </div>
                                        <div class="detail-col">
                                            <input type="text" name="semester" value="{{ $pd->semester }}" class="form-control form-control-sm mb-2" placeholder="Semester">
                                        </div>
                                    </div>
                                    <div class="detail-row">
                                        <div class="detail-col">
                                            <input type="number" name="tinggibadan" value="{{ $pd->tinggibadan }}" class="form-control form-control-sm" placeholder="Tinggi Badan (cm)">
                                        </div>
                                        <div class="detail-col">
                                            <input type="number" name="beratbadan" value="{{ $pd->beratbadan }}" class="form-control form-control-sm" placeholder="Berat Badan (kg)">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="action-buttons">
                            <template x-if="!edit">
                                <div class="d-flex flex-column gap-2">
                                    <button type="button" class="btn btn-sm btn-warning" @click="edit = true">Edit</button>
                                    <a href="{{ route('pesertadidik.destroy', $pd->nisn) }}"
                                       onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nisn }}').submit();"
                                       class="btn btn-sm btn-danger">Hapus</a>
                                    <a href="{{ route('statusgizi.create', $pd->nisn) }}" class="btn btn-sm btn-secondary">Hitung Z-Score</a>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div class="d-flex flex-column gap-2">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" @click="edit = false; showDetails = false">Batal</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </form>

                <form id="delete-form-{{ $pd->nisn }}" action="{{ route('pesertadidik.destroy', $pd->nisn) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @empty
            <div class="list-group-item text-center py-4">
                <p class="text-muted">Tidak ada data siswa ditemukan.</p>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>