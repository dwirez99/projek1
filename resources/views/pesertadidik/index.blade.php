<!DOCTYPE html>
<html lang="en">
<head>
    <script src="//unpkg.com/alpinejs" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .card {
            border: 1px solid #ddd;
            padding: 16px;
            margin: 8px;
            border-radius: 10px;
            width: 300px;
            float: left;
        }
        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<body>
    <h2>Data Peserta Didik</h2>
    <a href="{{ route('pesertadidik.create') }}">Tambah</a>

    @foreach ($pesertadidiks as $pd)
    <div class="card" x-data="{ edit: false }">
        <form method="POST" action="{{ route('pesertadidik.update', $pd->nisn) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div>
                <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : 'https://via.placeholder.com/300x200' }}" alt="Foto">
            </div>

            <div x-show="!edit">
                <strong>{{ $pd->namapd }}</strong><br>
                Orang Tua: {{ $pd->orangtua->namaortu }}<br>
                Lahir: {{ $pd->tanggallahir }}<br>
                Jenis Kelamin: {{ $pd->jeniskelamin }}
                Kelas: {{ $pd->kelas }}<br>
                Tahun Ajar: {{ $pd->tahunajar }}<br>
                Semester: {{ $pd->semester }}<br>
                Tinggi Badan: {{ $pd->tinggibadan }} cm<br>
                Berat Badan: {{ $pd->beratbadan }} kg<br>
            </div>

            <div x-show="edit">
                <input type="text" name="namapd" value="{{ $pd->namapd }}" placeholder="Nama"><br>
            
                <select name="idortu">
                    @foreach ($orangtuas as $ortu)
                        <option value="{{ $ortu->id }}" {{ $ortu->id == $pd->idortu ? 'selected' : '' }}>
                            {{ $ortu->namaortu }}
                        </option>
                    @endforeach
                </select><br>
            
                <input type="date" name="tanggallahir" value="{{ $pd->tanggallahir }}"><br>
            
                <select name="jeniskelamin">
                    <option value="Laki-laki" {{ $pd->jeniskelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ $pd->jeniskelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select><br>
            
                <input type="text" name="kelas" value="{{ $pd->kelas }}" placeholder="Kelas"><br>
                <input type="text" name="tahunajar" value="{{ $pd->tahunajar }}" placeholder="Tahun Ajar"><br>
                <input type="text" name="semester" value="{{ $pd->semester }}" placeholder="Semester"><br>
                <div style="position: relative; display: inline-block;">
                    <input type="number" name="tinggibadan" value="{{ $pd->tinggibadan }}" placeholder="Tinggi Badan" style="padding-right: 40px;">
                    <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">cm</span>
                </div><br>
                
                <div style="position: relative; display: inline-block;">
                    <input type="number" name="beratbadan" value="{{ $pd->beratbadan }}" placeholder="Berat Badan" style="padding-right: 40px;">
                    <span style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">kg</span>
                </div><br>
                <input type="file" name="foto"><br>
            </div>
            

            <div>
                <button type="button" x-show="!edit" @click="edit = true">Edit</button>
                <button type="submit" x-show="edit" @click="edit = false">Simpan</button>
                <a href="{{ route('pesertadidik.destroy', $pd->nisn) }}"
                   onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nisn }}').submit();">
                   Hapus
                </a>
                <a href="{{ route('statusgizi.create', $pd->nisn) }}">
                    <button type="button">Hitung Z-Score</button>
                </a>
            </div>
        </form>
        <form id="delete-form-{{ $pd->nisn }}" action="{{ route('pesertadidik.destroy', $pd->nisn) }}" method="POST" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
    </div>
    @endforeach
</body>
</html>
