<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peserta Didik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Tambahkan Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>
        .dropdown-list-item:hover {
            background-color: #f0f0f0; /* Warna abu-abu muda untuk hover */
        }
        [x-cloak] { display: none !important; } /* Sembunyikan elemen Alpine.js hingga siap */
    </style>
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

                        {{-- Komponen Pencarian Orang Tua dengan Alpine.js --}}
                        @php
                            $oldIdOrtu = old('idortu');
                            $oldNamaOrtu = '';
                            if ($oldIdOrtu) {
                                // Pastikan $orangtuas adalah koleksi dan tidak null
                                $resolvedOrangtua = ($orangtuas && method_exists($orangtuas, 'firstWhere')) ? $orangtuas->firstWhere('id', $oldIdOrtu) : null;
                                if ($resolvedOrangtua) {
                                    $oldNamaOrtu = $resolvedOrangtua->namaortu;
                                }
                            }
                            // Pastikan $orangtuas adalah koleksi yang bisa di-map, atau array kosong jika tidak
                            $orangtuasArray = ($orangtuas && method_exists($orangtuas, 'map'))
                                                ? $orangtuas->map(fn($o) => ['id' => $o->id, 'namaortu' => $o->namaortu])->values()->all()
                                                : [];
                            $orangtuasJson = json_encode($orangtuasArray);
                        @endphp

                        <script>
                            function orangTuaSearchData(orangtuasData, oldIdOrtu, oldNamaOrtu) {
                                return {
                                    searchTerm: oldNamaOrtu || '',
                                    allOrangtuas: orangtuasData,
                                    filteredOrangtuas: [],
                                    selectedOrangtuaId: oldIdOrtu || '',
                                    dropdownOpen: false,
                                    init() {
                                        this.filterOrangtuas();
                                    },
                                    filterOrangtuas() {
                                        if (this.searchTerm.trim() === '') {
                                            this.filteredOrangtuas = this.allOrangtuas;
                                        } else {
                                            this.filteredOrangtuas = this.allOrangtuas.filter(ortu =>
                                                ortu.namaortu.toLowerCase().includes(this.searchTerm.toLowerCase())
                                            );
                                        }
                                    },
                                    handleInput() {
                                        this.dropdownOpen = true;
                                        this.filterOrangtuas();
                                    },
                                    selectOrangtua(ortu) {
                                        this.searchTerm = ortu.namaortu;
                                        this.selectedOrangtuaId = ortu.id;
                                        this.dropdownOpen = false;
                                    },
                                    handleFocus() {
                                        this.dropdownOpen = true;
                                        this.filterOrangtuas();
                                    },
                                    handleBlur() {
                                        setTimeout(() => {
                                            const exactMatch = this.allOrangtuas.find(o => o.namaortu.toLowerCase() === this.searchTerm.toLowerCase());
                                            if (exactMatch) {
                                                this.searchTerm = exactMatch.namaortu;
                                                this.selectedOrangtuaId = exactMatch.id;
                                            } else {
                                                const previouslySelected = this.allOrangtuas.find(o => o.id == this.selectedOrangtuaId);
                                                if (previouslySelected) {
                                                    this.searchTerm = previouslySelected.namaortu;
                                                } else {
                                                    this.searchTerm = '';
                                                    this.selectedOrangtuaId = '';
                                                }
                                            }
                                            this.dropdownOpen = false;
                                        }, 200);
                                    }
                                };
                            }
                        </script>

                        <div x-data="orangTuaSearchData({{ $orangtuasJson }}, '{{ $oldIdOrtu }}', '{{ addslashes($oldNamaOrtu) }}')" x-init="init()" class="mb-3 position-relative" x-cloak>
                            <label for="searchOrangtua" class="form-label">Orang Tua</label>
                            <input type="text"
                                   id="searchOrangtua"
                                   class="form-control @error('idortu') is-invalid @enderror"
                                   x-model="searchTerm"
                                   x-on:input.debounce.250ms="handleInput"
                                   x-on:focus="handleFocus"
                                   x-on:blur="handleBlur"
                                   placeholder="Ketik nama orang tua..."
                                   autocomplete="off">

                            <input type="hidden" name="idortu" x-bind:value="selectedOrangtuaId">

                            <div x-show="dropdownOpen && filteredOrangtuas.length > 0"
                                 x-transition
                                 class="position-absolute w-100 bg-white border rounded shadow-lg mt-1"
                                 style="z-index: 1050; max-height: 200px; overflow-y: auto;"
                                 @click.outside="dropdownOpen = false">
                                <ul class="list-unstyled mb-0">
                                    <template x-for="ortu in filteredOrangtuas" :key="ortu.id">
                                        <li class="p-2 dropdown-list-item"
                                            style="cursor: pointer;"
                                            x-on:click="selectOrangtua(ortu)"
                                            x-text="ortu.namaortu">
                                        </li>
                                    </template>
                                </ul>
                            </div>
                            <div x-show="dropdownOpen && searchTerm !== '' && filteredOrangtuas.length === 0"
                                 class="position-absolute w-100 bg-white border rounded shadow-lg mt-1 p-2 text-muted"
                                 style="z-index: 1050;">
                                Tidak ada orang tua ditemukan.
                            </div>

                            @error('idortu')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Akhir Komponen Pencarian Orang Tua --}}

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
