<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\Pesertadidik;
use App\Models\StatusGizi;
use App\Models\Orangtua;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StatusgiziController extends Controller
{
    public function create($nis)
    {
        $pd = Pesertadidik::findOrFail($nis);
        return view('statusgizi.create', compact('pd'));
    }

    public function hitung(Request $request)
    {
        Log::info('Masuk ke fungsi hitung');

        $request->validate([
            'nis' => 'required|exists:pesertadidiks,nis',
        ]);

        Log::info("NIS setelah validasi: " . $request->nis);

        $pd = Pesertadidik::where('nis', $request->nis)->first();

        $tinggi = $pd->tinggibadan;
        $berat = $pd->beratbadan;
        $jeniskelamin = $pd->jeniskelamin;

        Log::info("Data PD: Tinggi=$tinggi, Berat=$berat, JK=$jeniskelamin");

        // Hitung IMT
        $imt = $berat / pow($tinggi / 100, 2);

        // Hitung umur tahun dan bulan
        $lahir = \Carbon\Carbon::parse($pd->tanggallahir);
        $sekarang = \Carbon\Carbon::now();
        $umur = $lahir->diff($sekarang); // CarbonInterval

        $umurTahun = $umur->y;
        $umurBulan = $umur->m;

        $umurKey = "$umurTahun-$umurBulan";
        Log::info("Umur: $umurTahun tahun $umurBulan bulan => Key: $umurKey");

        $umurKey = $umurTahun . '-' . $umurBulan;

        Log::info("Umur: $umurTahun tahun $umurBulan bulan => Key: $umurKey");

        $standar = [
            'Laki-laki' => [
                '5-0' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.6, '+2sd' => 18.3, '+3sd' => 20.2],
                '5-1' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.6, '+2sd' => 18.3, '+3sd' => 20.2],
                '5-2' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.6, '+2sd' => 18.3, '+3sd' => 20.2],
                '5-3' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.3, '+3sd' => 20.2],
                '5-4' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.3, '+3sd' => 20.3],
                '5-5' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.3, '+3sd' => 20.3],
                '5-6' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.4, '+3sd' => 20.4],
                '5-7' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.4, '+3sd' => 20.4],
                '5-8' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.4, '+3sd' => 20.5],
                '5-9' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.4, '+3sd' => 20.5],
                '5-10' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.5, '+3sd' => 20.6],
                '5-11' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.7, '+2sd' => 18.5, '+3sd' => 20.6],
                '6-0' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.8, '+2sd' => 18.5, '+3sd' => 20.7],
                '6-1' => ['-3sd' => 12.1, '-2sd' => 13.0, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.8, '+2sd' => 18.6, '+3sd' => 20.8],
                '6-2' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.8, '+2sd' => 18.6, '+3sd' => 20.8],
                '6-3' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.3, '+1sd' => 16.8, '+2sd' => 18.6, '+3sd' => 20.9],
                '6-4' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.4, '+1sd' => 16.8, '+2sd' => 18.7, '+3sd' => 21.0],
                '6-5' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.4, '+1sd' => 16.9, '+2sd' => 18.7, '+3sd' => 21.0],
                '6-6' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.4, '+1sd' => 16.9, '+2sd' => 18.7, '+3sd' => 21.1],
                '6-7' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.1, 'median' => 15.4, '+1sd' => 16.9, '+2sd' => 18.8, '+3sd' => 21.2],
                '6-8' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.2, 'median' => 15.4, '+1sd' => 16.9, '+2sd' => 18.8, '+3sd' => 21.3],
                '6-9' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.2, 'median' => 15.4, '+1sd' => 17.0, '+2sd' => 18.9, '+3sd' => 21.3],
                '6-10' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.2, 'median' => 15.4, '+1sd' => 17.0, '+2sd' => 18.9, '+3sd' => 21.4],
                '6-11' => ['-3sd' => 12.2, '-2sd' => 13.1, '-1sd' => 14.2, 'median' => 15.5, '+1sd' => 17.0, '+2sd' => 19.0, '+3sd' => 21.5],
            ],
            'Perempuan' => [
                '5-0' => ['-3sd' => 11.9, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 18.6, '+3sd' => 20.6],
                '5-1' => ['-3sd' => 11.8, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 18.9, '+3sd' => 21.3],
                '5-2' => ['-3sd' => 11.8, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 18.9, '+3sd' => 21.4],
                '5-3' => ['-3sd' => 11.8, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 18.9, '+3sd' => 21.5],
                '5-4' => ['-3sd' => 11.8, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 18.9, '+3sd' => 21.5],
                '5-5' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 19.0, '+3sd' => 21.6],
                '5-6' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 19.0, '+3sd' => 21.7],
                '5-7' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.2, '+1sd' => 16.9, '+2sd' => 19.0, '+3sd' => 21.7],
                '5-8' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.1, '+3sd' => 21.8],
                '5-9' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.1, '+3sd' => 21.9],
                '5-10' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.1, '+3sd' => 22.0],
                '5-11' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.2, '+3sd' => 22.1],
                '6-0' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.2, '+3sd' => 22.1],
                '6-1' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.3, '+3sd' => 22.2],
                '6-2' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.0, '+2sd' => 19.3, '+3sd' => 22.3],
                '6-3' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.1, '+2sd' => 19.3, '+3sd' => 22.4],
                '6-4' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.1, '+2sd' => 19.4, '+3sd' => 22.5],
                '6-5' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.1, '+2sd' => 19.4, '+3sd' => 22.6],
                '6-6' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.1, '+2sd' => 19.5, '+3sd' => 22.7],
                '6-7' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.2, '+2sd' => 19.5, '+3sd' => 22.8],
                '6-8' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.3, '+1sd' => 17.2, '+2sd' => 19.6, '+3sd' => 22.9],
                '6-9' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.4, '+1sd' => 17.2, '+2sd' => 19.6, '+3sd' => 23.0],
                '6-10' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.4, '+1sd' => 17.2, '+2sd' => 19.7, '+3sd' => 23.1],
                '6-11' => ['-3sd' => 11.7, '-2sd' => 12.7, '-1sd' => 13.9, 'median' => 15.4, '+1sd' => 17.3, '+2sd' => 19.7, '+3sd' => 23.2],
            ]
        ];

        if (!isset($standar[$jeniskelamin][$umurKey])) {
            return back()->withErrors(['nis' => "Data standar untuk umur $umurKey belum tersedia"]);
        }

        $dataStandar = $standar[$pd->jeniskelamin][$umurKey];
        $median = $dataStandar['median'];
        $minus1sd = $dataStandar['-1sd'];
        $plus1sd = $dataStandar['+1sd'];

        // Tentukan SD berdasarkan arah selisih
        if ($imt < $median) {
            $sd = $median - $minus1sd;
        } else {
            $sd = $plus1sd - $median;
        }

        // Hitung Z-Score
        $z_score = ($imt - $median) / $sd;

        // Tentukan status gizi
        if ($z_score < -2) {
            $status = 'Gizi Kurang';
        } elseif ($z_score >= -2 && $z_score <= 1) {
            $status = 'Gizi Baik';
        } elseif ($z_score > 1 && $z_score <= 2) {
            $status = 'Gizi Lebih';
        } else {
            $status = 'Obesitas';
        }

        Log::info("NIS: $request->nis, IMT: $imt, Umur: $umurTahun-$umurBulan, Z: $z_score");
        Log::info("Z-Score: {$z_score}, Status gizi: {$status}");

        return view('statusgizi.create', [
            'pd' => $pd,
            'z_score' => number_format($z_score, 3),
            'status_gizi' => $status
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:pesertadidiks,nis',
            'z_score' => 'required|numeric',
            'status_gizi' => 'required|string',
        ]);

        StatusGizi::create([
            'nis' => $request->nis,
            'z_score' => $request->z_score,
            'status' => $request->status_gizi,
            'tanggalpembuatan' => now(),
        ]);

        return redirect()->route('pesertadidik.index')->with('success', 'Status gizi berhasil disimpan.');

    }

    public function destroy($nis)
    {
        $status = StatusGizi::where('nis', $nis)->firstOrFail();
        $status->delete();

        return redirect()->back()->with('success', 'Data status gizi berhasil dihapus.');
    }


    public function index()
    {
        $status = StatusGizi::with('pesertaDidik')->get();
        return view('statusgizi.index', compact('status'));
    }

    public function indexOrtu()
    {

        $user = Auth::user();

        // Ambil data orang tua
        $orangTua = $user->orangtua;

        // Ambil semua peserta didik milik orang tua
        $statusGiziAnak = \App\Models\StatusGizi::whereHas('pesertaDidik', function ($query) use ($orangTua) {
            $query->where('idortu', $orangTua->id);
        })->with('pesertaDidik')->get();

        return view('orangtuas.statusgizi', compact('statusGiziAnak'));
    }

    public function chart()
    {
        // Ambil bulan unik dari data
        $bulanList = \App\Models\StatusGizi::selectRaw('DATE_FORMAT(tanggalpembuatan, "%Y-%m") as bulan')
            ->distinct()
            ->orderBy('bulan', 'desc')
            ->pluck('bulan');

        return view('statusgizi.chart', compact('bulanList'));
    }

    public function chartData(Request $request)
    {
        $bulan = $request->get('bulan');
        if (!$bulan) {
            $bulan = now()->format('Y-m');
        }

        $data = \App\Models\StatusGizi::with('pesertaDidik')
            ->whereRaw('DATE_FORMAT(tanggalpembuatan, "%Y-%m") = ?', [$bulan])
            ->get();

        $kelasA = ['Gizi Kurang' => 0, 'Gizi Baik' => 0, 'Gizi Lebih' => 0, 'Obesitas' => 0];
        $kelasB = ['Gizi Kurang' => 0, 'Gizi Baik' => 0, 'Gizi Lebih' => 0, 'Obesitas' => 0];

        foreach ($data as $item) {
            $status = $item->status;
            $kelas = $item->pesertaDidik->kelas ?? 'A';

            if (!in_array($status, ['Gizi Kurang', 'Gizi Baik', 'Gizi Lebih', 'Obesitas'])) continue;

            if ($kelas === 'A') {
                $kelasA[$status]++;
            } elseif ($kelas === 'B') {
                $kelasB[$status]++;
            }
        }

        return response()->json([
            'kelasA' => $kelasA,
            'kelasB' => $kelasB
        ]);
    }

    public function exportPdf(Request $request)
    {
        $ids = $request->query('ids');

        if ($ids) {
            $idArray = explode(',', $ids);
            $status = StatusGizi::with('pesertaDidik')
                ->whereIn('idstatus', $idArray)
                ->get();

            // Susun ulang sesuai urutan yang dikirim
            $status = collect($idArray)->map(function ($id) use ($status) {
                return $status->firstWhere('idstatus', $id);
            })->filter();
        } else {
            $status = StatusGizi::with('pesertaDidik')
                ->orderBy('tanggalpembuatan', 'asc')
                ->get();
        }

        $pdf = Pdf::loadView('statusgizi.pdf', [
            'filteredStatus' => $status->values()
        ])->setPaper('A4', 'landscape');

        return $pdf->download('Laporan_statusgizi_' . now()->format('dmY') . '.pdf');
    }

    public function bulkDelete(Request $request)
    {
        $nis = explode(',', $request->selected_nis);
        StatusGizi::whereIn('nis', $nis)->delete();
        return redirect()->back()->with('success', 'Data yang dipilih berhasil dihapus.');
    }
}
