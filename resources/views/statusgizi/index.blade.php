@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Data Status Gizi</h3>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>NISN</th>
                <th>Nama</th>
                <th>Z-Score</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($status as $item)
                <tr>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->pesertaDidik->namapd }}</td>
                    <td>{{ $item->z_score }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->tanggalpembuatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
