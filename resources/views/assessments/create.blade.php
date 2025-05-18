@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-clipboard-check me-2"></i>
                Form Penilaian Peserta Didik
            </h4>
        </div>
        <div class="card-body">
            <!-- Informasi Peserta -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Nama</th>
                            <td>{{ $peserta->namapd }}</td>
                        </tr>
                        <tr>
                            <th>NISN</th>
                            <td>{{ $peserta->nisn }}</td>
                        </tr>
                        <tr>
                            <th>Kelas</th>
                            <td>{{ $peserta->kelas }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">Usia</th>
                            <td>{{ \Carbon\Carbon::parse($peserta->tanggallahir)->age }} tahun</td>
                        </tr>
                        <tr>
                            <th>Tinggi Badan</th>
                            <td>{{ $peserta->tinggibadan }} cm</td>
                        </tr>
                        <tr>
                            <th>Berat Badan</th>
                            <td>{{ $peserta->beratbadan }} kg</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Form Penilaian -->
            <form method="POST" action="{{ route('assessment.store') }}">
                @csrf
                <input type="hidden" name="nisn" value="{{ $peserta->nisn }}">

                <!-- Motorik Kasar -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">A. Motorik Kasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>1. Dapat melompat dengan dua kaki</label>
                                    <select name="indicators[motorik_kasar][lompat]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan" selected>Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[motorik_kasar][lompat]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>2. Dapat menangkap bola dengan kedua tangan</label>
                                    <select name="indicators[motorik_kasar][tangkap_bola]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan">Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[motorik_kasar][tangkap_bola]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motorik Halus -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">B. Motorik Halus</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>1. Dapat memegang pensil dengan benar</label>
                                    <select name="indicators[motorik_halus][pegang_pensil]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan">Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[motorik_halus][pegang_pensil]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>2. Dapat menggunting garis lurus</label>
                                    <select name="indicators[motorik_halus][gunting]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan">Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[motorik_halus][gunting]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kognitif -->
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">C. Perkembangan Kognitif</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>1. Mengenal angka 1-10</label>
                                    <select name="indicators[kognitif][angka]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan">Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[kognitif][angka]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>2. Mengenal warna dasar</label>
                                    <select name="indicators[kognitif][warna]" class="form-select" required>
                                        <option value="">- Pilih -</option>
                                        <option value="Belum Berkembang">Belum Berkembang</option>
                                        <option value="Mulai Berkembang">Mulai Berkembang</option>
                                        <option value="Berkembang Sesuai Harapan">Berkembang Sesuai Harapan</option>
                                        <option value="Sangat Berkembang">Sangat Berkembang</option>
                                    </select>
                                    <textarea name="comments[kognitif][warna]" class="form-control mt-2" placeholder="Catatan..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="form-group mb-4">
                    <label class="form-label">Catatan Umum</label>
                    <textarea name="general_notes" class="form-control" rows="3" placeholder="Observasi khusus lainnya..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('assessments.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection