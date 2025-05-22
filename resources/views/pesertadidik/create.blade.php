<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peserta Didik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali input Anda!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <a href="{{ route('pesertadidik.index') }}" class="btn btn-sm btn-primary ms-2">Lihat Data</a>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">Tambah Peserta Didik</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('pesertadidik.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label>Orang Tua</label>
                            <select name="idortu" class="form-select">
                                <option value="">Pilih Orang Tua</option>
                                @foreach ($orangtuas as $ortu)
                                    <option value="{{ $ortu->id }}" {{ old('idortu') == $ortu->id ? 'selected' : '' }}>{{ $ortu->namaortu }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="namapd" class="form-control" placeholder="Nama" value="{{ old('namapd') }}">
                        </div>

                        <div class="mb-3">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggallahir" class="form-control" value="{{ old('tanggallahir') }}">
                        </div>

                        <div class="mb-3">
                            <label>Jenis Kelamin</label>
                            <select name="jeniskelamin" class="form-select">
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-Laki" {{ old('jeniskelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="Perempuan" {{ old('jeniskelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Kelas</label>
                            <select name="kelas" class="form-select">
                                <option value="">Pilih Kelas</option>
                                <option value="A" {{ old('kelas') == 'A' ? 'selected' : '' }}>A</option>
                                <option value="B" {{ old('kelas') == 'B' ? 'selected' : '' }}>B</option>
                            </select>
                        </div>

                        {{-- <div class="mb-3">
                            <label>Tahun Ajar</label>
                            <select name="tahunajar" class="form-select">
                                <option value="">Pilih Tahun Ajar</option>
                                <option value="2024/2025" {{ old('tahunajar') == '2024/2025' ? 'selected' : '' }}>2024/2025</option>
                                <option value="2025/2026" {{ old('tahunajar') == '2025/2026' ? 'selected' : '' }}>2025/2026</option>
                            </select>
                        </div> --}}

                        {{-- <div class="mb-3">
                            <label>Semester</label>
                            <select name="semester" class="form-select">
                                <option value="">Pilih Semester</option>
                                <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                                <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>Genap</option>
                            </select>
                        </div> --}}

                        <div class="mb-3">
                            <label>Tinggi Badan</label>
                            <input type="number" name="tinggibadan" class="form-control" placeholder="Tinggi Badan" value="{{ old('tinggibadan') }}">
                        </div>

                        <div class="mb-3">
                            <label>Berat Badan</label>
                            <input type="number" name="beratbadan" class="form-control" placeholder="Berat Badan" value="{{ old('beratbadan') }}">
                        </div>

                        <div class="mb-3">
                            <label>Foto</label>
                            <input type="file" name="foto" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-success">Simpan</button>
                        <a href="{{ route('pesertadidik.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
