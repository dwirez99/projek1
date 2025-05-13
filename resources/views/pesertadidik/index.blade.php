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
        <h1 class="fw-bold mb-2 mb-md-0">Daftar Siswa</h1>
        <form action="{{ route('pesertadidik.index') }}" method="GET" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="cari" class="form-control rounded-pill" placeholder="Cari nama siswa..." value="{{ request('cari') }}" style="max-width: 200px;">
            <button type="submit" class="btn btn-light rounded-pill shadow-sm">Cari</button>
        </form>
    </div>

    {{-- Tambah Data --}}
    <div class="text-left mb-4">
        <a href="{{ route('pesertadidik.create') }}" class="btn btn-success">Tambah Siswa</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse ($pesertadidiks as $pd)
            <div class="col-md-6 mb-4">
                <div class="card" x-data="{ edit: false }">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : asset('default.jpg') }}"
                                 class="img-fluid rounded-start" alt="Foto Siswa">
                        </div>
                        <div class="col-md-8">
                            <form method="POST" action="{{ route('pesertadidik.update', $pd->nisn) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="card-body">
                                    <template x-if="!edit">
                                        <div>
                                            <h5 class="card-title">{{ $pd->namapd }}</h5>
                                            <p class="card-text">
                                                Orang Tua: {{ $pd->orangtua->namaortu }}<br>
                                                Lahir: {{ $pd->tanggallahir }}<br>
                                                Jenis Kelamin: {{ $pd->jeniskelamin }}<br>
                                                Kelas: {{ $pd->kelas }}<br>
                                                Tahun Ajar: {{ $pd->tahunajar }}<br>
                                                Semester: {{ $pd->semester }}<br>
                                                Tinggi Badan: {{ $pd->tinggibadan }} cm<br>
                                                Berat Badan: {{ $pd->beratbadan }} kg
                                            </p>
                                        </div>
                                    </template>

                                    <template x-if="edit">
                                        <div>
                                            <input type="text" name="namapd" value="{{ $pd->namapd }}" class="form-control mb-2">
                                            <select name="idortu" class="form-select mb-2">
                                                @foreach ($orangtuas as $ortu)
                                                    <option value="{{ $ortu->id }}" {{ $ortu->id == $pd->idortu ? 'selected' : '' }}>
                                                        {{ $ortu->namaortu }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="date" name="tanggallahir" value="{{ $pd->tanggallahir }}" class="form-control mb-2">
                                            <select name="jeniskelamin" class="form-select mb-2">
                                                <option value="Laki-laki" {{ $pd->jeniskelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $pd->jeniskelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            <input type="text" name="kelas" value="{{ $pd->kelas }}" class="form-control mb-2">
                                            <input type="text" name="tahunajar" value="{{ $pd->tahunajar }}" class="form-control mb-2">
                                            <input type="text" name="semester" value="{{ $pd->semester }}" class="form-control mb-2">
                                            <input type="number" name="tinggibadan" value="{{ $pd->tinggibadan }}" class="form-control mb-2" placeholder="Tinggi Badan">
                                            <input type="number" name="beratbadan" value="{{ $pd->beratbadan }}" class="form-control mb-2" placeholder="Berat Badan">
                                            <input type="file" name="foto" class="form-control mb-2">
                                        </div>
                                    </template>

                                    <div class="d-flex flex-wrap gap-2">
                                        <template x-if="!edit">
                                            <div>
                                                <button type="button" class="btn btn-warning" @click="edit = true">Edit</button>
                                                <a href="{{ route('pesertadidik.destroy', $pd->nisn) }}"
                                                   onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nisn }}').submit();"
                                                   class="btn btn-danger">Hapus</a>
                                                <a href="{{ route('statusgizi.create', $pd->nisn) }}" class="btn btn-secondary">Hitung Z-Score</a>
                                            </div>
                                        </template>

                                        <template x-if="edit">
                                            <div>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                <button type="button" class="btn btn-secondary" @click="edit = false">Batal</button>
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
