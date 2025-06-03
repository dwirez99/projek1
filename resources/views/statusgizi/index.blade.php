@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Gizi Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//unpkg.com/alpinejs" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        th, td { vertical-align: middle !important; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Status Gizi Peserta Didik</h2>
        <a href="{{ route('statusgizi.exportPdf') }}" onclick="printFiltered()" class="btn btn-danger">
            <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="bulkDeleteForm" action="{{ route('statusgizi.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_nis" id="selectednisInput" />
    </form>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari data..." />
    </div>

    <table class="table table-bordered table-hover align-middle" id="statusTable" data-sort-dir="asc">
        <thead class="table-dark">
            <tr>
                <th style>Kelas</th>
                <th><input type="checkbox" id="selectAll" /></th>
                <th>NIS</th>
                <th>Nama Anak <i class="bi bi-arrow-down-up" onclick="sortTable(4)"></i></th>
                <th>Tinggi Badan</th>
                <th>Berat Badan</th>
                <th>Z-Score</th>
                <th>Status</th>
                <th>Tanggal <i class="bi bi-arrow-down-up" onclick="sortTable(9)"></i></th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody style="background-color: white">
            @foreach ($status as $item)
            <tr>
                <td>{{ $item->pesertaDidik->kelas ?? 'A' }}</td>
                <td><input type="checkbox" class="row-checkbox" /></td>
                <td>{{ $item->nis }}</td>
                <td>{{ $item->pesertaDidik->namapd ?? '-' }}</td>
                <td>{{ $item->pesertaDidik->tinggibadan ?? '-' }} cm</td>
                <td>{{ $item->pesertaDidik->beratbadan ?? '-' }} kg</td>
                <td>{{ $item->z_score }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggalpembuatan)->format('Y-m-d') }}</td>
                <td>
                    <form onsubmit="return handleDelete(event, '{{ route('statusgizi.destroy', $item->nis) }}')">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Chart Section -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container mt-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Filter Rentang Tanggal Status Gizi</h5>
        </div>
        <div class="card-body row g-3">
            <div class="col-md-6">
                <label for="startDate" class="form-label">Tanggal Mulai</label>
                <input type="date" id="startDate" class="form-control" onchange="updateCharts()" />
            </div>
            <div class="col-md-6">
                <label for="endDate" class="form-label">Tanggal Akhir</label>
                <input type="date" id="endDate" class="form-control" onchange="updateCharts()" />
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Chart Status Gizi Kelas A</h5>
        </div>
        <div class="card-body">
            <canvas id="chartKelasA" style="height: 50px;"></canvas>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Chart Status Gizi Kelas B</h5>
        </div>
        <div class="card-body">
            <canvas id="chartKelasB" style="height: 50px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartA = null, chartB = null;

    function getChartDataByClass() {
        const rows = document.querySelectorAll('#statusTable tbody tr');
        const data = { A: {}, B: {} };

        const start = document.getElementById('startDate')?.value;
        const end = document.getElementById('endDate')?.value;
        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        rows.forEach(row => {
            if (row.style.display === 'none') return;

            const kelas = row.cells[0].textContent.trim();
            const status = row.cells[7].textContent.trim();
            const tanggal = row.cells[8].textContent.trim();

            const dateObj = new Date(tanggal);

            if (isNaN(dateObj)) return;
            if (startDate && dateObj < startDate) return;
            if (endDate && dateObj > endDate) return;

            const bulan = dateObj.toISOString().slice(0, 7);
            if (!data[kelas]) data[kelas] = {};
            if (!data[kelas][bulan]) data[kelas][bulan] = {};
            if (!data[kelas][bulan][status]) data[kelas][bulan][status] = 0;
            data[kelas][bulan][status]++;
        });

        return data;
    }

    function prepareChartData(data, kelas) {
        if (!data[kelas]) return { labels: [], datasets: [] };
        const bulanLabels = Object.keys(data[kelas]).sort();
        const statusLabels = ['Gizi Kurang', 'Gizi Baik', 'Gizi Lebih', 'Obesitas'];
        const colors = {
            'Gizi Kurang': '#dc3545',
            'Gizi Baik': '#198754',
            'Gizi Lebih': '#ffc107',
            'Obesitas': '#0d6efd'
        };

        const datasets = statusLabels.map(status => ({
            label: status,
            borderColor: colors[status],
            backgroundColor: colors[status] + '55',
            tension: 0.3,
            fill: false,
            data: bulanLabels.map(b => data[kelas][b][status] || 0)
        }));

        return { labels: bulanLabels, datasets };
    }

    function renderChart(canvasId, chartRef, chartData) {
        const ctx = document.getElementById(canvasId).getContext('2d');
        if (chartRef) {
            chartRef.data = chartData;
            chartRef.update();
        } else {
            return new Chart(ctx, {
                type: 'line',
                data: chartData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { size: 14 } }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return `${context.dataset.label}: ${context.raw}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Bulan',
                                font: { size: 14 }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Anak',
                                font: { size: 14 }
                            },
                            ticks: { stepSize: 1, precision: 0 }
                        }
                    }
                }
            });
        }
    }

    function updateCharts() {
        const data = getChartDataByClass();
        const chartDataA = prepareChartData(data, 'A');
        const chartDataB = prepareChartData(data, 'B');

        chartA = renderChart('chartKelasA', chartA, chartDataA) || chartA;
        chartB = renderChart('chartKelasB', chartB, chartDataB) || chartB;
    }

    window.onload = function () {
        updateCharts();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
