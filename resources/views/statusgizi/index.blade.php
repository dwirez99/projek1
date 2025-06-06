@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Status Gizi Peserta Didik</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> {{-- Using Font Awesome for icons --}}
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Custom styles can be added here if needed, or integrated into Tailwind config */
        [x-cloak] { display: none !important; }
    </style>
</head>
<body>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Status Gizi Peserta Didik</h1>
        <a href="{{ route('statusgizi.exportPdf') }}" onclick="printFiltered()" class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center">
            <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <form id="bulkDeleteForm" action="{{ route('statusgizi.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_ids" id="selectedIdsInput" /> {{-- Changed name to selected_ids for clarity --}}
    </form>

    <div class="mb-6">
        <input type="text" id="searchInput" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Cari berdasarkan Nama, NIS, Status, atau Tanggal (YYYY-MM-DD)..." />
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto mb-8">
        <table class="min-w-full divide-y divide-gray-200" id="statusTable" data-sort-dir="asc">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider hidden">ID</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider hidden">Kelas</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">
                        <input type="checkbox" id="selectAll" class="form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"/>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">NIS</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable(4)">Nama Anak <i class="fas fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Tinggi Badan</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Berat Badan</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Z-Score</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable(9)">Tanggal <i class="fas fa-sort ml-1"></i></th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($status as $item)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden">{{ $item->idstatus }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 hidden">{{ $item->pesertaDidik->kelas ?? 'A' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        <input type="checkbox" class="row-checkbox form-checkbox h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" value="{{ $item->idstatus }}"/>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->nis }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $item->pesertaDidik->namapd ?? '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->pesertaDidik->tinggibadan ?? '-' }} cm</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->pesertaDidik->beratbadan ?? '-' }} kg</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->z_score }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $item->status }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($item->tanggalpembuatan)->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                        {{-- Asumsi route 'statusgizi.destroy' menerima idstatus, bukan nis untuk penghapusan spesifik record status gizi --}}
                        <form onsubmit="return handleDelete(event, '{{ route('statusgizi.destroy', $item->idstatus) }}')">
                             @csrf
                             @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 transition-colors duration-150">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-4 py-10 text-center text-sm text-gray-500">
                        Tidak ada data status gizi ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
     <button type="button" id="bulkDeleteButton" class="mb-6 bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center" disabled>
        <i class="fas fa-trash-alt mr-2"></i> Hapus Data Terpilih
    </button>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Filter Rentang Tanggal Status Gizi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="startDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" id="startDate" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="updateChartsAndTable()" />
            </div>
            <div>
                <label for="endDate" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                <input type="date" id="endDate" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" onchange="updateChartsAndTable()" />
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Chart Status Gizi Kelas A</h2>
        <div>
            <canvas id="chartKelasA" style="height: 300px; width: 100%;"></canvas>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Chart Status Gizi Kelas B</h2>
        <div>
            <canvas id="chartKelasB" style="height: 300px; width: 100%;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let chartA = null, chartB = null;
    const table = document.getElementById('statusTable');
    const tbody = table.getElementsByTagName('tbody')[0];
    const rows = Array.from(tbody.getElementsByTagName('tr'));

    // Function to handle individual delete
    function handleDelete(event, actionUrl) {
        event.preventDefault();
        if (confirm('Yakin ingin menghapus data ini?')) {
            const form = event.target;
            // Create a temporary form to submit with DELETE method
            const tempForm = document.createElement('form');
            tempForm.method = 'POST'; // HTML forms only support GET/POST, method spoofing with _method
            tempForm.action = actionUrl;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            tempForm.innerHTML = `
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="${csrfToken}">
            `;
            document.body.appendChild(tempForm);
            tempForm.submit();
        }
        return false;
    }

    function getChartDataByClass() {
        const rows = document.querySelectorAll('#statusTable tbody tr');
        const data = { A: {}, B: {} };

        const start = document.getElementById('startDate')?.value;
        const end = document.getElementById('endDate')?.value;
        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        rows.forEach(row => {
            // Check if row is visible (not filtered out by search or date)
            if (row.classList.contains('hidden-by-search') || row.classList.contains('hidden-by-date')) return;

            const kelas = row.cells[1].textContent.trim();
            const status = row.cells[8].textContent.trim();
            const tanggal = row.cells[9].textContent.trim();
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
                type: 'bar',
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

    function filterTableByDate() {
        const start = document.getElementById('startDate')?.value;
        const end = document.getElementById('endDate')?.value;
        const startDate = start ? new Date(start) : null;
        const endDate = end ? new Date(end) : null;

        rows.forEach(row => {
            const tanggalCell = row.cells[9];
            if (!tanggalCell) return;
            const tanggal = tanggalCell.textContent.trim();
            const dateObj = new Date(tanggal);

            let showRow = true;
            if (startDate && dateObj < startDate) showRow = false;
            if (endDate && dateObj > endDate) showRow = false;

            if (showRow) {
                row.classList.remove('hidden-by-date');
                // Ensure it's not hidden by search either
                if (!row.classList.contains('hidden-by-search')) {
                    row.style.display = '';
                }
            } else {
                row.classList.add('hidden-by-date');
                row.style.display = 'none';
            }
        });
    }

    function updateChartsAndTable() {
        filterTableByDate(); // Filter table first
        const data = getChartDataByClass();
        const chartDataA = prepareChartData(data, 'A');
        const chartDataB = prepareChartData(data, 'B');

        chartA = renderChart('chartKelasA', chartA, chartDataA) || chartA;
        chartB = renderChart('chartKelasB', chartB, chartDataB) || chartB;
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        rows.forEach(row => {
            const nis = row.cells[3].textContent.toLowerCase();
            const nama = row.cells[4].textContent.toLowerCase();
            const status = row.cells[8].textContent.toLowerCase();
            const tanggal = row.cells[9].textContent.toLowerCase();

            if (nis.includes(searchTerm) || nama.includes(searchTerm) || status.includes(searchTerm) || tanggal.includes(searchTerm)) {
                row.classList.remove('hidden-by-search');
                // Ensure it's not hidden by date either
                if (!row.classList.contains('hidden-by-date')) {
                    row.style.display = '';
                }
            } else {
                row.classList.add('hidden-by-search');
                row.style.display = 'none';
            }
        });
        updateChartsAndTable(); // Update charts after search filter
    });

    // Sorting (basic example, can be improved)
    function sortTable(columnIndex) {
        const sortDir = table.dataset.sortDir === 'asc' ? 'desc' : 'asc';
        table.dataset.sortDir = sortDir;

        const sortedRows = Array.from(rows).sort((a, b) => {
            const valA = a.cells[columnIndex].textContent.trim();
            const valB = b.cells[columnIndex].textContent.trim();
            if (sortDir === 'asc') {
                return valA.localeCompare(valB, undefined, {numeric: true});
            } else {
                return valB.localeCompare(valA, undefined, {numeric: true});
            }
        });

        sortedRows.forEach(row => tbody.appendChild(row));
    }

    // Bulk delete
    const selectAllCheckbox = document.getElementById('selectAll');
    const rowCheckboxes = document.querySelectorAll('.row-checkbox');
    const bulkDeleteButton = document.getElementById('bulkDeleteButton');

    selectAllCheckbox.addEventListener('change', function() {
        rowCheckboxes.forEach(checkbox => checkbox.checked = this.checked);
        bulkDeleteButton.disabled = !this.checked;
    });

    rowCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const anyChecked = Array.from(rowCheckboxes).some(cb => cb.checked);
            bulkDeleteButton.disabled = !anyChecked;
            selectAllCheckbox.checked = Array.from(rowCheckboxes).every(cb => cb.checked);
        });
    });

    bulkDeleteButton.addEventListener('click', function() {
        const selectedIds = Array.from(rowCheckboxes)
                                .filter(cb => cb.checked)
                                .map(cb => cb.value); // Assuming checkbox value is the idstatus
        if (selectedIds.length > 0) {
            document.getElementById('selectedIdsInput').value = selectedIds.join(',');
            document.getElementById('bulkDeleteForm').submit();
        } else {
            alert('Pilih setidaknya satu data untuk dihapus.');
        }
    });

    // PDF Print (placeholder)
    function printFiltered() {
        // This function needs to be implemented based on how you want to generate PDF.
        // It might involve collecting filtered data and sending it to a server-side PDF generation endpoint.
        alert('Fungsi cetak PDF perlu diimplementasikan.');
        // Example: window.open('{{ route('statusgizi.exportPdf') }}' + '?params_for_filtered_data', '_blank');
    }

    window.onload = function () {
        updateChartsAndTable();
    }
</script>
</body>
</html>
