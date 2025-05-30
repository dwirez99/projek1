@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="public/css/style.css">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
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
        .judul-halaman {
        font-family: "Baloo Thambi 2", system-ui;
        font-size: 60px;
        color: #fff;
        background: linear-gradient(to right, #1c92d2, #f2fcfe);
        text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
        padding: 40px 50px;
        margin-bottom: 20px;
    }
    </style>
</head>
<body>
<div class="judul-halaman">Kelola Orang Tua</div>

<div class="container mt-4">
    {{-- Header dan Pencarian --}}

    <div class="header-bar d-flex flex-wrap justify-content-between align-items-center mb-4">

    </div>

    {{-- Tombol Tambah Data --}}
    <div class="text-left mb-4">
        <a href="{{ route('pesertadidik.create') }}" class="btn btn-success">Tambah Siswa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('pesertadidik.index') }}" method="GET" class="d-flex flex-wrap align-items-center gap-2 mb-4">
        <input type="text" name="cari" class="form-control " placeholder="Cari nama siswa..." value="{{ request('cari') }}" style="max-width: 200px;">

        {{-- Filter Kelas --}}
        <select name="kelas" class="form-select form-select-sm" style="max-width: 150px;">
            <option value="">Semua Kelas</option>
            <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
            <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
        </select>

        {{-- Filter Tahun Ajar
        <select name="tahunajar" class="form-select form-select-sm" style="max-width: 160px;">
            <option value="">Semua Tahun Ajar</option>
            <option value="2024/2025" {{ request('tahunajar') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
            <option value="2025/2026" {{ request('tahunajar') == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
        </select> --}}

        {{-- Sort Nama --}}
        <select name="sort" class="form-select form-select-sm" style="max-width: 180px;">
            <option value="">Urutkan Nama</option>
            <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
            <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
        </select>

        <button type="submit" class="btn btn-light rounded-pill shadow-sm">Terapkan</button>
    </form>


    <div class="list-group">
        @forelse ($pesertadidiks as $pd)
            <div class="list-group-item list-item mb-3 p-3" x-data="{ edit: false, showDetails: false }">
                <form method="POST" action="{{ route('pesertadidik.update', $pd->nis) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="d-flex align-items-start gap-3">
                        {{-- Kolom Kiri: Foto --}}
                        <div>
                            <img src="{{ $pd->foto ? asset('storage/media/' . $pd->foto) : asset('default.jpg') }}"
                                 class="student-photo" alt="Foto Siswa">
                            <template x-if="edit">
                                <input type="file" name="foto" class="form-control form-control-sm mt-2" style="width: 80px;">
                            </template>
                        </div>

                        {{-- Kolom Kanan: Informasi --}}
                        <div class="student-info">
                            <template x-if="!edit">
                                <div>
                                    <div class="student-name">{{ $pd->namapd }} <small class="text-muted">(NIS: {{ $pd->nis }})</small></div>
                                    <div class="student-detail mb-2">
                                        <div>Orang Tua: {{ $pd->orangtua->namaortu }} ({{ $pd->orangtua->nickname }})</div>
                                        <div>Lahir: {{ $pd->tanggallahir }} | {{ $pd->jeniskelamin }}</div>
                                        <div>Kelas: {{ $pd->kelas }}</div>
                                        <div>TB/BB: {{ $pd->tinggibadan }} cm / {{ $pd->beratbadan }} kg</div>
                                        <div>No. Telp Ortu: {{ $pd->orangtua->notelportu }}</div>
                                        <div >Status Gizi (Terbaru): <strong>{{ $pd->statusgiziTerbaru->status ?? '-' }}</strong></div>
                                        <div>Z - Score: {{ $pd->statusgiziTerbaru->z_score ?? '-' }}</div>
                                        <div><a href="{{ route('statusgizi.index') }}">Riwayat Status Gizi</a></div>

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
                                            <select name="kelas" class="form-select form-select-sm mb-2"> {{-- Ubah name menjadi "kelas" (lowercase) --}}
                                                <option value="A" {{ $pd->kelas == 'A' ? 'selected' : '' }}>KELAS A</option> {{-- Perbaiki value --}}
                                                <option value="B" {{ $pd->kelas == 'B' ? 'selected' : '' }}>KELAS B</option> {{-- Perbaiki value --}}
                                            </select>
                                        </div>
                                    </div>
                                    <div class="detail-row">
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
<a href="{{ route('pesertadidik.destroy', $pd->nis) }}"
                                       onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nis }}').submit();"
                                       class="btn btn-sm btn-danger">Hapus</a>
                                    <a href="{{ route('statusgizi.create', $pd->nis) }}" class="btn btn-sm btn-secondary">Hitung Z-Score</a>
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

<form id="delete-form-{{ $pd->nis }}" action="{{ route('pesertadidik.destroy', $pd->nis) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
<form action="{{ route('pesertadidik.upload_penilaian', $pd->nis) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mt-2">
                        <label class="form-label">Upload File Penilaian (.pdf/.doc/.docx)</label>
                        <input type="file" name="file" accept=".pdf,.doc,.docx" class="form-control form-control-sm" required>

                        @if ($pd->file_penilaian)
                            <small class="text-success">File saat ini:
                                <a href="{{ asset('storage/' . $pd->file_penilaian) }}" target="_blank">Lihat File</a>
                            </small>
                        @endif
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-sm btn-primary">Simpan File Penilaian</button>
                    </div>
                </form>

            </div>
        @empty
            <div class="list-group-item text-center py-4">
                <p class="text-muted">Tidak ada data siswa ditemukan.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">
        <nav class="pagination-sm">
            {{ $pesertadidiks->withQueryString()->links() }}
        </nav>
    </div>

</div>
</body>
</html>