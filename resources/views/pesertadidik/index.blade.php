@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Newsreader:ital,opsz,wght@0,6..72,200..800;1,6..72,200..800&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .judul-halaman {
            font-family: "Baloo Thambi 2", system-ui;
            font-size: 3rem; /* Adjusted for Tailwind's rem unit */
            color: #fff;
            background: linear-gradient(to right, #1c92d2, #f2fcfe);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
            padding: 2.5rem 3rem; /* Adjusted for Tailwind's rem unit */
            margin-bottom: 1.25rem; /* Adjusted for Tailwind's rem unit */
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body >
<div class="judul-halaman">Kelola Peserta Didik</div>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8"
     x-data="{
        zScoreActive: localStorage.getItem('zScoreActive') === 'true'
     }"
     x-init="$watch('zScoreActive', value => localStorage.setItem('zScoreActive', value))"
>

    {{-- Tombol Tambah Data --}}
    <div class="mb-6 text-left">
        <a href="{{ route('pesertadidik.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            Tambah Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <p class="font-bold">Sukses!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form action="{{ route('pesertadidik.index') }}" method="GET" class="mb-8 p-4 bg-white rounded-lg shadow-md">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label for="cari" class="block text-sm font-medium text-gray-700">Cari Nama</label>
                <input type="text" name="cari" id="cari" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Nama siswa..." value="{{ request('cari') }}">
            </div>

            <div>
                <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
                <select name="kelas" id="kelas" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua Kelas</option>
                    <option value="A" {{ request('kelas') == 'A' ? 'selected' : '' }}>Kelas A</option>
                    <option value="B" {{ request('kelas') == 'B' ? 'selected' : '' }}>Kelas B</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status Pemeriksaan</label>
                <select name="status" id="status" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Semua Status</option>
                    <option value="True" {{ request('status') == 'True' ? 'selected' : '' }}>Diperiksa</option>
                    <option value="False" {{ request('status') == 'False' ? 'selected' : '' }}>Belum</option>
                </select>
            </div>

            <div>
                <label for="sort" class="block text-sm font-medium text-gray-700">Urutkan Nama</label>
                <select name="sort" id="sort" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="">Default</option>
                    <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                </select>
            </div>

            <div class="sm:col-span-2 md:col-span-1 lg:col-span-2 flex items-end space-x-2">
                <button type="submit" class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Terapkan Filter
                </button>
                 <button type="button" @click="zScoreActive = !zScoreActive"
                         class="w-full sm:w-auto text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out"
                         :class="zScoreActive ? 'bg-red-500 hover:bg-red-600' : 'bg-teal-500 hover:bg-teal-600'">
                    <span x-text="zScoreActive ? 'Nonaktifkan Perhitungan Z-Score' : 'Aktifkan Perhitungan Z-Score'"></span>
                </button>
            </div>
        </div>
    </form>

    <div class="space-y-6">
        @forelse ($pesertadidiks as $pd)
            <div class="bg-white shadow-lg rounded-xl p-6 transition-all duration-300 hover:shadow-xl" x-data="{ edit: false, showDetails: false }">
                <form method="POST" action="{{ route('pesertadidik.update', $pd->nis) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-col md:flex-row items-start gap-6">
                        {{-- Kolom Kiri: Foto & Input Foto (saat edit) --}}
                        <div class="flex-shrink-0">
                            <img src="{{ $pd->foto ? asset('storage/foto' . $pd->foto) : asset('default.jpg') }}"
                                 class="w-24 h-24 md:w-32 md:h-32 object-cover rounded-lg border-2 border-gray-200 shadow-sm" alt="Foto Siswa">
                            <template x-if="edit">
                                <input type="file" name="foto" class="mt-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 w-full max-w-xs">
                            </template>
                        </div>

                        {{-- Kolom Tengah: Informasi Siswa --}}
                        <div class="flex-grow min-w-0">
                            <template x-if="!edit">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $pd->namapd }}
                                        <span class="text-sm text-gray-500 font-normal">(NIS: {{ $pd->nis }})</span>
                                    </h3>
                                    <div class="mt-2 space-y-1 text-sm text-gray-600">
                                        <p><span class="font-medium text-gray-700">Orang Tua:</span> {{ $pd->orangtua->namaortu }} ({{ $pd->orangtua->nickname }})</p>
                                        <p><span class="font-medium text-gray-700">Lahir:</span> {{ \Carbon\Carbon::parse($pd->tanggallahir)->isoFormat('D MMMM YYYY') }} | {{ $pd->jeniskelamin }}</p>
                                        <p><span class="font-medium text-gray-700">Kelas:</span> {{ $pd->kelas }}</p>
                                        <p><span class="font-medium text-gray-700">TB/BB:</span> {{ $pd->tinggibadan ?? '-' }} cm / {{ $pd->beratbadan ?? '-' }} kg</p>
                                        <p><span class="font-medium text-gray-700">No. Telp Ortu:</span> {{ $pd->orangtua->notelportu }}</p>
                                        <p><span class="font-medium text-gray-700">Status Gizi (Terbaru):</span> <strong class="text-indigo-600">{{ $pd->statusgiziTerbaru->status ?? '-' }} | {{ $pd->statusgiziTerbaru?->tanggalpembuatan
                                            ? \Carbon\Carbon::parse($pd->statusgiziTerbaru->tanggalpembuatan)->isoFormat('D MMMM YYYY')
                                            : '-' }}
                                        </strong></p>
                                        <p><span class="font-medium text-gray-700">Z-Score:</span> {{ $pd->statusgiziTerbaru->z_score ?? '-' }}</p>
                                        <p><a href="{{ route('statusgizi.index', ['nis' => $pd->nis]) }}" class="text-blue-600 hover:text-blue-800 hover:underline">Riwayat Status Gizi</a></p>
                                    </div>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div class="space-y-3">
                                    <div>
                                        <label for="namapd-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                                        <input type="text" name="namapd" id="namapd-{{$pd->nis}}" value="{{ $pd->namapd }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Nama Siswa">
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="idortu-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Orang Tua</label>
                                            <select name="idortu" id="idortu-{{$pd->nis}}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @foreach ($orangtuas as $ortu)
                                                    <option value="{{ $ortu->id }}" {{ $ortu->id == $pd->idortu ? 'selected' : '' }}>
                                                        {{ $ortu->namaortu }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="tanggallahir-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                            <input type="date" name="tanggallahir" id="tanggallahir-{{$pd->nis}}" value="{{ $pd->tanggallahir }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="jeniskelamin-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                            <select name="jeniskelamin" id="jeniskelamin-{{$pd->nis}}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="Laki-laki" {{ $pd->jeniskelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="Perempuan" {{ $pd->jeniskelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="kelas-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Kelas</label>
                                            <select name="kelas" id="kelas-{{$pd->nis}}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="A" {{ $pd->kelas == 'A' ? 'selected' : '' }}>Kelas A</option>
                                                <option value="B" {{ $pd->kelas == 'B' ? 'selected' : '' }}>Kelas B</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="tinggibadan-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm)</label>
                                            <input type="number" name="tinggibadan" id="tinggibadan-{{$pd->nis}}" value="{{ $pd->tinggibadan }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Tinggi (cm)">
                                        </div>
                                        <div>
                                            <label for="beratbadan-{{$pd->nis}}" class="block text-sm font-medium text-gray-700">Berat Badan (kg)</label>
                                            <input type="number" name="beratbadan" id="beratbadan-{{$pd->nis}}" value="{{ $pd->beratbadan }}" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Berat (kg)">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Kolom Kanan: Tombol Aksi --}}
                        <div class="flex-shrink-0 mt-4 md:mt-0 md:ml-auto">
                            <template x-if="!edit">
                                <div class="flex flex-col space-y-2 w-full md:w-auto">
                                    <button type="button" class="w-full text-sm bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" @click="edit = true">Edit</button>
                                    <a href="{{ route('pesertadidik.destroy', $pd->nis) }}"
                                       onclick="event.preventDefault(); document.getElementById('delete-form-{{ $pd->nis }}').submit();"
                                       class="w-full text-sm text-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Hapus</a>
                                    <a x-show="zScoreActive" href="{{ route('statusgizi.create', $pd->nis) }}"
                                       class="w-full text-sm text-center bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out"
                                       x-cloak>Hitung Z-Score</a>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div class="flex flex-col space-y-2 w-full md:w-auto">
                                    <button type="submit" class="w-full text-sm bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">Simpan</button>
                                    <button type="button" class="w-full text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out" @click="edit = false; showDetails = false">Batal</button>
                                </div>
                            </template>
                        </div>
                    </div>
                </form>

                <form id="delete-form-{{ $pd->nis }}" action="{{ route('pesertadidik.destroy', $pd->nis) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>

                {{-- Form Upload Penilaian --}}
                <form action="{{ route('pesertadidik.upload_penilaian', $pd->nis) }}" method="POST" enctype="multipart/form-data" class="mt-6 pt-4 border-t border-gray-200">
                    @csrf
                    <div class="flex flex-col sm:flex-row sm:items-end sm:gap-4">
                        <div class="flex-grow mb-2 sm:mb-0">
                            <label for="file-penilaian-{{$pd->nis}}" class="block text-sm font-medium text-gray-700 mb-1">Upload File Penilaian (.pdf/.doc/.docx)</label>
                            <input type="file" name="file" id="file-penilaian-{{$pd->nis}}" accept=".pdf,.doc,.docx" class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 w-full border border-gray-300 rounded-lg p-1" required>
                        </div>
                        <button type="submit" class="flex-shrink-0 text-sm bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Simpan File Penilaian
                        </button>
                    </div>
                    <div class="mt-2">
                        @if ($pd->file_penilaian)
                            <p class="text-xs text-green-600">File saat ini:
                                <a href="{{ asset('storage/' . $pd->file_penilaian) }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">{{ basename($pd->file_penilaian) }}</a>
                            </p>
                        @else
                             <p class="text-xs text-gray-500">Belum ada file penilaian.</p>
                        @endif
                    </div>
                </form>
            </div>
        @empty
            <div class="bg-white shadow-md rounded-lg p-6 text-center">
                <p class="text-gray-500">Tidak ada data siswa ditemukan.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-8">
        <nav class="flex justify-center">
            {{ $pesertadidiks->withQueryString()->links() }}
        </nav>
    </div>
</div>
</body>
</html>
