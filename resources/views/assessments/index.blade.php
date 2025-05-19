@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Manajemen Penilaian Peserta Didik</h2>

    <!-- Search Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('assessments.index') }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control"
                           placeholder="Cari Nama/NISN..." value="{{ $search }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Peserta Didik -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            <th>Status Penilaian</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesertaDidik as $key => $peserta)
                        <tr>
                            <td>{{ $pesertaDidik->firstItem() + $key }}</td>
                            <td>{{ $peserta->namapd }}</td>
                            <td>{{ $peserta->nisn }}</td>
                            <td>{{ $peserta->kelas }}</td>
                            <td>
                                @if($peserta->assessments->count() > 0)
                                    <span class="badge bg-success">Sudah Dinilai</span>
                                @else
                                    <span class="badge bg-warning">Belum Dinilai</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('assessments.create', $peserta->nisn) }}"
                                   class="btn btn-sm btn-primary" title="Tambah Penilaian">
                                   <i class="fas fa-plus"></i>
                                </a>

                                @php
                                    $role = auth()->user()->getRoleNames()->first();
                                @endphp
                                                            
                                <a href="{{ route('assessments.create', $peserta->nisn) }}"
                                   class="btn btn-sm btn-primary" title="Tambah Penilaian">
                                   <i class="fas fa-plus"></i>
                                </a>
                                
                                @if($peserta->assessments->count() > 0)
                                    @if($role === 'guru')
                                        <a href="{{ route('assessments.show.guru', $peserta->nisn) }}"
                                           class="btn btn-sm btn-info" title="Lihat History">
                                           <i class="fas fa-history"></i>
                                        </a>
                                    @elseif($role === 'orangtua')
                                        <a href="{{ route('assessments.show.ortu', $peserta->nisn) }}"
                                           class="btn btn-sm btn-info" title="Lihat History">
                                           <i class="fas fa-history"></i>
                                        </a>
                                    @endif
                                @endif



                                <!-- Tombol edit bisa ditambahkan sesuai kebutuhan -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $pesertaDidik->links() }}
        </div>
    </div>
</div>
@endsection