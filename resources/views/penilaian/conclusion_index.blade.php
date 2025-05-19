@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Anak</h2>

    @if($children->isEmpty())
        <p>Tidak ada data anak yang tersedia.</p>
    @else
        <div class="row">
            @foreach($children as $child)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $child->namapd }}</h5>
                            <p class="card-text"><strong>NISN:</strong> {{ $child->nisn }}</p>
                            <p class="card-text"><strong>Status Gizi Terakhir:</strong> {{ $child->statusgizi ? $child->statusgizi->status : 'Tidak ada data' }}</p>
                            <a href="{{ route('penilaian.conclusion', $child->nisn) }}" class="btn btn-primary">Lihat Kesimpulan</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
