<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Alpine.js (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            background-color: #00bfff;
        }

        h1 {
            color: black;
            font-weight: bold;
            font-size: 2.5rem;
        }

        .search-input {
            border-radius: 20px;
            border: 3px solid black;
            background-color: white;
            padding: 0.5rem 1rem;
            font-size: 1.2rem;
            flex: 1;
        }

        .cari-btn {
            background-color: white;
            color: black;
            border: 3px solid black;
            border-radius: 20px;
            box-shadow: 3px 3px 0 black;
            padding: 0.5rem 1rem;
            font-weight: bold;
        }

        .btn {
            border-radius: 20px !important;
            box-shadow: 3px 3px 0 black;
            font-weight: bold;
            width: 100%;
            margin-bottom: 4px;
        }

        .btn-green { background-color: #28a745; color: white; }
        .btn-red { background-color: #dc3545; color: white; }
        .btn-blue { background-color: #007bff; color: white; }
        .btn-secondary { background-color: #6c757d; color: white; }

        .card {
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            flex: 1 1 calc(50% - 1rem);
        }

        .grid-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            padding: 2rem;
        }

        /* Responsive untuk perangkat mobile */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
                text-align: center;
            }

            .d-flex.justify-content-between {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .search-input {
                width: 100%;
                font-size: 1rem;
                padding: 0.4rem 0.8rem;
            }

            .cari-btn {
                width: 100%;
                font-size: 1rem;
            }

            .grid-container {
                flex-direction: column;
                padding: 1rem;
            }

            .card {
                max-width: 100% !important;
            }

            .row.g-0 {
                flex-direction: column;
            }

            .col-md-4, .col-md-8 {
                width: 100%;
            }

            .btn {
                font-size: 0.9rem;
                padding: 0.4rem 0.8rem;
            }

            .toast {
                width: 90%;
                left: 5%;
                right: 5%;
                bottom: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="container" x-data="siswaApp()">
    <div class="d-flex justify-content-between align-items-center my-4 flex-wrap">
        <h1 class="mb-0">Daftar Siswa</h1>
        <div class="d-flex align-items-center gap-2" style="width: 100%; max-width: 500px;">
            <input type="text" x-model="search" class="search-input" placeholder="Cari nama siswa...">
        </div>
    </div>

    <div class="grid-container">
        <template x-if="filteredSiswa.length === 0">
            <div 
                class="alert alert-warning text-center w-100 fs-4 fw-bold"
                x-transition:enter="transition ease-out duration-300" 
                x-transition:enter-start="opacity-0 translate-y-2" 
                x-transition:enter-end="opacity-100 translate-y-0" 
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-2"
            >
                🔍 Siswa tidak ditemukan.
            </div>
        </template>

        <template x-for="s in filteredSiswa" :key="s.id">
            <div class="card mb-3" style="max-width: 600px;" x-data="{
                edit: false,
                form: {
                    nama: s.nama,
                    wali: s.wali,
                    ttl: s.ttl,
                    jnskelamin: s.jnskelamin,
                    kelas: s.kelas,
                    thnajar: s.thnajar,
                    semester: s.semester,
                    tb: s.tb,
                    bb: s.bb,
                    foto: ''
                },
                oldFoto: s.foto
            }">
                <div class="row g-0">
                    <div class="col-md-4 text-center p-2">
                        <img :src="form.foto instanceof File ? URL.createObjectURL(form.foto) : '/storage/foto/' + oldFoto" class="img-fluid rounded" alt="Foto">

                        <div class="mt-3">
                            <button class="btn btn-green" @click.prevent="if (edit) {
                                    let data = new FormData();
                                    for (const key in form) {
                                        data.append(key, form[key]);
                                    }
                                    data.append('_token', '{{ csrf_token() }}');
                                    data.append('_method', 'PUT');

                                    fetch('/siswa/' + s.id, {
                                        method: 'POST',
                                        body: data
                                    })
                                    .then(res => res.json())
                                    .then(response => {
                                        if (response.success) {
                                            edit = false;
                                            $root.toast = true;
                                            $root.message = 'Data berhasil diperbarui!';
                                            setTimeout(() => $root.toast = false, 3000);
                                        }
                                    });
                                } else {
                                    edit = true;
                                }" 
                                x-text="edit ? 'Simpan' : 'Edit'"></button>

                            <form :action="'/siswa/' + s.id" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-red">Hapus</button>
                            </form>

                            <a :href="'/siswa/zscore/' + s.id" class="btn btn-blue">Hitung Z-Score</a>

                            <button class="btn btn-secondary" x-show="edit" @click="edit = false">Batal</button>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card-body">
                            <template x-if="!edit">
                                <div>
                                    <h5 class="card-title" x-text="form.nama"></h5>
                                    <p><strong>Wali:</strong> <span x-text="form.wali"></span></p>
                                    <p><strong>TTL:</strong> <span x-text="new Date(form.ttl).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })"></span></p>
                                    <p><strong>Jenis Kelamin:</strong> <span x-text="form.jnskelamin"></span></p>
                                    <p><strong>Kelas:</strong> <span x-text="form.kelas"></span></p>
                                    <p><strong>Tahun Ajar:</strong> <span x-text="form.thnajar"></span></p>
                                    <p><strong>Semester:</strong> <span x-text="form.semester"></span></p>
                                    <p><strong>Tinggi Badan:</strong> <span x-text="form.tb"></span> cm</p>
                                    <p><strong>Berat Badan:</strong> <span x-text="form.bb"></span> kg</p>
                                </div>
                            </template>

                            <template x-if="edit">
                                <div>
                                    <input x-model="form.nama" placeholder="Nama" class="form-control mb-2">
                                    <input x-model="form.wali" placeholder="Wali" class="form-control mb-2">
                                    <input x-model="form.ttl" type="date" class="form-control mb-2">
                                    <select x-model="form.jnskelamin" class="form-control mb-2">
                                        <option value="Laki - Laki">Laki - Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <select x-model="form.kelas" class="form-control mb-2">
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                    </select>
                                    <select x-model="form.thnajar" class="form-control mb-2">
                                        <option value="2024/2025">2024/2025</option>
                                        <option value="2025/2026">2025/2026</option>
                                        <option value="2026/2027">2026/2027</option>
                                    </select>
                                    <select x-model="form.semester" class="form-control mb-2">
                                        <option value="Ganjil">Ganjil</option>
                                        <option value="Genap">Genap</option>
                                    </select>
                                    <input x-model="form.tb" type="number" placeholder="Tinggi Badan (cm)" class="form-control mb-2">
                                    <input x-model="form.bb" type="number" placeholder="Berat Badan (kg)" class="form-control mb-2">
                                    <input @change="form.foto = $event.target.files[0]" type="file" class="form-control mb-2">
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Toast -->
    <div class="toast align-items-center text-white bg-success border-0 position-fixed bottom-0 end-0 m-4" x-show="toast" role="alert" x-transition>
        <div class="d-flex">
            <div class="toast-body" x-text="message"></div>
        </div>
    </div>
</div>

<script>
function siswaApp() {
    return {
        search: '',
        toast: false,
        message: '',
        siswaList: @json($siswa),
        get filteredSiswa() {
            if (!this.search) return this.siswaList;
            return this.siswaList.filter(s =>
                s.nama.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }
}
</script>

</body>
</html>
