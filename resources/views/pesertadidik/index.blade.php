@extends('layouts.app')

@section('title', 'Data Peserta Didik')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Data Peserta Didik</h2>
    <a href="{{ route('pesertadidik.create') }}" class="btn btn-primary mb-3">Tambah</a>

    <div>
        @foreach ($pesertadidiks as $pd)
            <div class="card" x-data="{ edit: false }" style="border: 1px solid #ff6262; padding: 16px; margin: 8px; border-radius: 10px; width: 300px; float: left;">
                <form method="POST" action="{{ route('pesertadidik.update', $pd->nisn) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div>
                        <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : 'https://via.placeholder.com/300x200' }}" alt="Foto" style="width: 100%; height: 200px; object-fit: cover;">
                    </div>

                    <div x-show="!edit">
                        <strong>{{ $pd->namapd }}</strong><br>
                        Orang Tua: {{ $pd->orangtua->namaortu }}<br>
                        Lahir: {{ $pd->tanggallahir }}<br>
                        Jenis Kelamin: {{ $pd->jeniskelamin }}<br>
                        Kelas: {{ $pd->kelas }}<br>
                        Tahun Ajar: {{ $pd->tahunajar }}<br>
                        Semester: {{ $pd->semester }}<br>
                        Tinggi Badan: {{ $pd->tinggibadan }} cm<br>
                        Berat Badan: {{ $pd->beratbadan }} kg<br>
                    </div>

                    <div x-show="edit">
                        <input type="text" name="namapd" value="{{ $pd->namapd }}" placeholder="Nama" class="form-control mb-2">

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

                        <input type="text" name="kelas" value="{{ $pd->kelas }}" placeholder="Kelas" class="form-control mb-2">
                        <input type="text" name="tahunajar" value="{{ $pd->tahunajar }}" placeholder="Tahun Ajar" class="form-control mb-2">
                        <input type="text" name="semester" value="{{ $pd->semester }}" placeholder="Semester" class="form-control mb-2">

                        <div class="mb-2" style="position: relative;">
                            <input type="number" name="tinggibadan" value="{{ $pd->tinggibadan }}" placeholder="Tinggi Badan" class="form-control" style="padding-right: 40px;">
                            <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">cm</span>
                        </div>

                        <div class="mb-2" style="position: relative;">
                            <input type="number" name="beratbadan" value="{{ $pd->beratbadan }}" placeholder="Berat Badan" class="form-control" style="padding-right: 40px;">
                            <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">kg</span>
                        </div>

                        <input type="file" name="foto" class="form-control mb-2">
                    </div>

                    <div>
                        <button type="button" x-show="!edit" @click="edit = true" class="btn btn-warning btn-sm">Edit</button>
                        <button type="submit" x-show="edit" @click="edit = false" class="btn btn-success btn-sm">Simpan</button>
                        <a href="{{ route('pesertadidik.destroy', $pd->nisn) }}"
                           onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nisn }}').submit();"
                           class="btn btn-danger btn-sm">
                           Hapus
                        </a>
                        <a href="{{ route('statusgizi.create', $pd->nisn) }}" class="btn btn-info btn-sm">
                            Hitung Z-Score
                        </a>
                    </div>
                </form>
                <form id="delete-form-{{ $pd->nisn }}" action="{{ route('pesertadidik.destroy', $pd->nisn) }}" method="POST" style="display:none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endforeach
        <div style="clear: both;"></div>
    </div>

    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
