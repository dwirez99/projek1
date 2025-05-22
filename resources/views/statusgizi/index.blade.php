@extends('layouts.app')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Gizi Peserta Didik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <style>
        th, td { vertical-align: middle !important; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Status Gizi Peserta Didik</h2>
        <div>
            <a href="javascript:void(0)" onclick="printFiltered()" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf-fill"></i> Cetak PDF
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="bulkDeleteForm" action="{{ route('statusgizi.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data terpilih?')">
        @csrf
        @method('DELETE')
        <input type="hidden" name="selected_nis" id="selectednisInput">
    </form>

    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari data...">
    </div>

    <table class="table table-bordered table-hover align-middle" id="statusTable" data-sort-dir="asc">
        <thead class="table-dark">
            <tr>
                <th style="display:none">ID</th> <!-- Kolom tersembunyi -->
                <th><input type="checkbox" id="selectAll"></th>
                <th>NIS</th>
                <th>Nama Anak<i class="bi bi-arrow-down-up" onclick="sortTable(3)"></i></th>
                <th>Tinggi Badan</th>
                <th>Berat Badan</th>
                <th>Z-Score</th>
                <th>Status</th>
                <th>Tanggal <i class="bi bi-arrow-down-up" onclick="sortTable(8)"></i></th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($status as $item)
            <tr>
                <td style="display:none">{{ $item->idstatus }}</td>
                <td style="background-color:white;"><input type="checkbox" class="row-checkbox"></td>
                <td style="background-color:white;">{{ $item->nis }}</td>
                <td style="background-color:white;">{{ $item->pesertaDidik->namapd ?? '-' }}</td>
                <td style="background-color:white;">{{ $item->pesertaDidik->tinggibadan ?? '-' }} cm</td>
                <td style="background-color:white;">{{ $item->pesertaDidik->beratbadan ?? '-' }} kg</td>
                <td style="background-color:white;">{{ $item->z_score }}</td>
                <td style="background-color:white;">{{ $item->status }}</td>
                <td style="background-color:white;">{{ \Carbon\Carbon::parse($item->tanggalpembuatan)->format('d M Y') }}</td>
                <td style="background-color:white;">
                    <form onsubmit="return handleDelete(event, '{{ route('statusgizi.destroy', $item->nis) }}')">
                        <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash-fill"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Pencarian
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#statusTable tbody tr");
        rows.forEach(row => {
            const match = Array.from(row.cells).some(td => td.textContent.toLowerCase().includes(filter));
            row.style.display = match ? "" : "none";
        });
    });

    function sortTable(n) {
        const table = document.getElementById("statusTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);
        let dir = table.getAttribute('data-sort-dir') === 'asc' ? 'desc' : 'asc';
        table.setAttribute('data-sort-dir', dir);

        rows.sort((a, b) => {
            const x = a.cells[n].textContent.trim().toLowerCase();
            const y = b.cells[n].textContent.trim().toLowerCase();

            if (!isNaN(x) && !isNaN(y)) {
                return dir === 'asc' ? x - y : y - x;
            }

            return dir === 'asc' ? x.localeCompare(y) : y.localeCompare(x);
        });

        rows.forEach(row => tbody.appendChild(row));
    }

    function printFiltered() {
        const rows = [...document.querySelectorAll("#statusTable tbody tr")]
            .filter(row => row.style.display !== "none")
            .map(row => ({
                idstatus: row.cells[0].textContent.trim()
            }));

        if (rows.length === 0) {
            alert('Tidak ada data yang bisa dicetak.');
            return;
        }

        const idList = rows.map(r => r.idstatus).join(',');
        const url = `{{ route('statusgizi.exportPdf') }}?ids=${encodeURIComponent(idList)}`;
        window.open(url, '_blank');
    }

    document.getElementById('selectAll').addEventListener('click', function() {
        const checked = this.checked;
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = checked);
    });

    function handleDelete(event, individualDeleteUrl) {
        event.preventDefault();

        const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkedBoxes.length > 0) {
            const selectedNis = [];
            checkedBoxes.forEach(box => {
                const nis = box.closest('tr').cells[2].textContent.trim();
                selectedNis.push(nis);
            });
            document.getElementById('selectednisInput').value = selectedNis.join(',');
            document.getElementById('bulkDeleteForm').submit();
        } else {
            if (confirm('Yakin ingin menghapus data ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = individualDeleteUrl;
                form.innerHTML = `@csrf @method('DELETE')`;
                document.body.appendChild(form);
                form.submit();
            }
        }
        return false;
    }
</script>
</body>
</html>
