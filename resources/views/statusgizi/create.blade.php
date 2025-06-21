@extends('layouts.app')
<!DOCTYPE html>
<html>
<head>
    <title>Status Gizi Peserta Didik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>

        .container-main {
            max-width: 960px;
            margin: auto;
            padding: 3rem 1rem;
            position: relative;
        }

        .card-statusgiziz {
            background-color: #fcfcfc;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);

        }

        .img-container img {
            width: 250px;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            border: 4px solid #e0e0e0;
        }

        .info h4 {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .info small {
            color: #666;
            font-size: 0.9rem;
        }

        .info p {
            margin-bottom: 0.8rem;
            font-size: 1rem;
        }

        .label {
            font-weight: 500;
            color: #333;
        }

        .value {
            border-bottom: 2px solid #ccc;
            display: inline-block;
            min-width: 120px;
            padding-bottom: 3px;
            margin-left: 6px;
        }

        .status-gizi {
            font-weight: bold;
            color: #28a745;
        }

        .btn-rounded {
            border-radius: 12px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }

        .btn-rounded:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-dark {
            background-color: #212529;
            color: #fff;
        }

        .btn-secondary {
            background-color: #dee2e6;
            color: #000;
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 2rem;
            color: #333;
            text-decoration: none;
            z-index: 1000;
        }

        .btn-back:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .card-custom {
                flex-direction: column;
                text-align: center;
            }

            .btn-back {
                top: 15px;
                left: 15px;
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container-main">
        {{-- Alert untuk error dari controller (misalnya, data tidak cocok dengan dataset Z-score) --}}
        @if ($errors->has('nis'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first('nis') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Kartu Data -->
        <div class="card card-statusgiziz">

            <!-- Tombol Kembali -->
            <a href="{{ route('pesertadidik.index') }}" class="btn-back" data-bs-toggle="tooltip" data-bs-placement="right" title="Kembali ke daftar">
                <i class="bi bi-arrow-left-circle-fill"></i>
            </a>
            <div class="img-container">
                <img src="{{ $pd->foto ? asset('storage/' . $pd->foto) : 'https://via.placeholder.com/250x300' }}" alt="Foto">
            </div>

            <div class="info">
                <h4>{{ $pd->namapd }}</h4>
                <small>{{ $pd->jeniskelamin }} | {{ \Carbon\Carbon::parse($pd->tanggallahir)->diff(\Carbon\Carbon::now())->format('%y Tahun %m Bulan') }}</small>

                <p><span class="label">Tinggi Badan (cm):</span> <span class="value">{{ $pd->tinggibadan }} cm</span></p>
                <p><span class="label">Berat Badan (kg):</span> <span class="value">{{ $pd->beratbadan }} kg</span></p>

                @isset($status_gizi)
                    <p><span class="label">Status Gizi:</span> <span class="status-gizi">{{ $status_gizi }}</span></p>
                @endisset

                <div class="d-flex gap-2 mt-3 flex-wrap">
                    <form action="{{ route('statusgizi.hitung') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nis" value="{{ $pd->nis }}">
                        <button type="submit" class="btn btn-dark btn-rounded">Hitung Z-Score</button>
                    </form>

                    @isset($status_gizi)
                    <form action="{{ route('statusgizi.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="nis" value="{{ $pd->nis }}">
                        <input type="hidden" name="status_gizi" value="{{ $status_gizi }}">
                        <input type="hidden" name="z_score" value="{{ $z_score }}">
                        <button type="submit" class="btn btn-secondary btn-rounded">Simpan</button>
                    </form>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <!-- Tooltip script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el))
    </script>
</body>
</html>
