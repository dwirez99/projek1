@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Peserta Didik</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Thambi+2:wght@700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .judul-halaman {
            font-family: "Baloo Thambi 2", system-ui;
            font-size: 3rem;
            color: #fff;
            background: linear-gradient(to right, #1c92d2, #f2fcfe);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
            padding: 2rem 3rem;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="judul-halaman">
        Tambah Peserta Didik
    </div>

    <div class="max-w-3xl mx-auto px-4 py-6">
        {{-- Notifikasi Error --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Terjadi kesalahan pada input Anda:</strong>
                @if ($errors->has('foto'))
                    <p>Ukuran file foto tidak boleh lebih dari 2MB.</p>
                @endif
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <a href="{{ route('pesertadidik.index') }}" class="ml-4 bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">Lihat Data</a>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg">
            <div class="bg-blue-600 text-white text-xl font-semibold px-6 py-4 rounded-t-lg">
                Tambah Peserta Didik
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route('pesertadidik.store') }}" enctype="multipart/form-data">
                    @csrf

                    {{-- Alpine.js Search --}}
                    @php
                        $oldIdOrtu = old('idortu');
                        $oldNamaOrtu = '';
                        if ($oldIdOrtu && $orangtuas && method_exists($orangtuas, 'firstWhere')) {
                            $resolvedOrangtua = $orangtuas->firstWhere('id', $oldIdOrtu);
                            if ($resolvedOrangtua) $oldNamaOrtu = $resolvedOrangtua->namaortu;
                        }
                        $orangtuasJson = json_encode($orangtuas->map(fn($o) => ['id' => $o->id, 'namaortu' => $o->namaortu])->values()->all());
                    @endphp

                    <script>
                        function orangTuaSearchData(orangtuasData, oldIdOrtu, oldNamaOrtu) {
                            return {
                                searchTerm: oldNamaOrtu || '',
                                allOrangtuas: orangtuasData,
                                filteredOrangtuas: [],
                                selectedOrangtuaId: oldIdOrtu || '',
                                dropdownOpen: false,
                                init() { this.filterOrangtuas(); },
                                filterOrangtuas() {
                                    this.filteredOrangtuas = this.searchTerm.trim() === ''
                                        ? this.allOrangtuas
                                        : this.allOrangtuas.filter(ortu =>
                                            ortu.namaortu.toLowerCase().includes(this.searchTerm.toLowerCase()));
                                },
                                handleInput() { this.dropdownOpen = true; this.filterOrangtuas(); },
                                selectOrangtua(ortu) {
                                    this.searchTerm = ortu.namaortu;
                                    this.selectedOrangtuaId = ortu.id;
                                    this.dropdownOpen = false;
                                },
                                handleFocus() { this.dropdownOpen = true; this.filterOrangtuas(); },
                                handleBlur() {
                                    setTimeout(() => {
                                        const exact = this.allOrangtuas.find(o => o.namaortu.toLowerCase() === this.searchTerm.toLowerCase());
                                        if (exact) {
                                            this.searchTerm = exact.namaortu;
                                            this.selectedOrangtuaId = exact.id;
                                        } else {
                                            const prev = this.allOrangtuas.find(o => o.id == this.selectedOrangtuaId);
                                            this.searchTerm = prev ? prev.namaortu : '';
                                            this.selectedOrangtuaId = prev ? prev.id : '';
                                        }
                                        this.dropdownOpen = false;
                                    }, 200);
                                }
                            };
                        }
                    </script>

                    <div x-data="orangTuaSearchData({{ $orangtuasJson }}, '{{ $oldIdOrtu }}', '{{ addslashes($oldNamaOrtu) }}')" x-init="init()" class="mb-4 relative" x-cloak>
                        <label class="block mb-1 font-semibold">Orang Tua</label>
                        <input type="text" x-model="searchTerm" x-on:input.debounce.250ms="handleInput" x-on:focus="handleFocus"
                               x-on:blur="handleBlur"
                               class="w-full border-gray-300 rounded px-4 py-2 border focus:outline-none focus:ring focus:border-blue-400"
                               placeholder="Ketik nama orang tua..." autocomplete="off">
                        <input type="hidden" name="idortu" x-bind:value="selectedOrangtuaId">

                        <div x-show="dropdownOpen && filteredOrangtuas.length > 0"
                             class="absolute bg-white border w-full mt-1 rounded shadow z-10 max-h-48 overflow-y-auto">
                            <template x-for="ortu in filteredOrangtuas" :key="ortu.id">
                                <div @click="selectOrangtua(ortu)"
                                     class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                     x-text="ortu.namaortu"></div>
                            </template>
                        </div>
                        <div x-show="dropdownOpen && searchTerm !== '' && filteredOrangtuas.length === 0"
                             class="absolute bg-white border w-full mt-1 rounded shadow px-4 py-2 text-gray-500">
                            Tidak ada orang tua ditemukan.
                        </div>
                        @error('idortu')
                            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Input Fields --}}
                    @php
                        $fields = [
                            ['name' => 'namapd', 'label' => 'Nama', 'type' => 'text'],
                            ['name' => 'tanggallahir', 'label' => 'Tanggal Lahir', 'type' => 'date'],
                            ['name' => 'tinggibadan', 'label' => 'Tinggi Badan', 'type' => 'number'],
                            ['name' => 'beratbadan', 'label' => 'Berat Badan', 'type' => 'number'],
                        ];
                    @endphp

                    @foreach ($fields as $field)
                        <div class="mb-4">
                            <label class="block mb-1 font-semibold">{{ $field['label'] }}</label>
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}"
                                   class="w-full border-gray-300 rounded px-4 py-2 border focus:outline-none focus:ring"
                                   value="{{ old($field['name']) }}">
                        </div>
                    @endforeach

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Jenis Kelamin</label>
                        <select name="jeniskelamin" class="w-full border-gray-300 rounded px-4 py-2 border focus:outline-none focus:ring">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki" {{ old('jeniskelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="Perempuan" {{ old('jeniskelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Kelas</label>
                        <select name="kelas" class="w-full border-gray-300 rounded px-4 py-2 border focus:outline-none focus:ring">
                            <option value="">Pilih Kelas</option>
                            <option value="A" {{ old('kelas') == 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('kelas') == 'B' ? 'selected' : '' }}>B</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-semibold">Foto</label>
                        <input type="file" name="foto" class="w-full border-gray-300 rounded px-4 py-2 border focus:outline-none focus:ring">
                    </div>

                    <div class="flex justify-between mt-6">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded shadow">
                            Simpan
                        </button>
                        <a href="{{ route('pesertadidik.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded shadow">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
