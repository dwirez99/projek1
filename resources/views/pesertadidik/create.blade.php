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
            <strong>Terjadi kesalahan pada input Anda:</strong>
            @if ($errors->has('foto'))
                <p>Ukuran file foto tidak boleh lebih dari 2MB (2048 kilobytes).</p>
            @endif
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
