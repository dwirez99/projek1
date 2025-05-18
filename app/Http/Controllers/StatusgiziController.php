<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Statusgizi;
use App\Models\Orangtua;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusgiziController extends Controller
{
    public function create($nisn)
    {
        $pd = Pesertadidik::findOrFail($nisn);
        return view('statusgizi.create', compact('pd'));
    }

    public function hitung(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:pesertadidiks,nisn',
        ]);

        $pd = Pesertadidik::where('nisn', $request->nisn)->first();

        $tinggi = $pd->tinggibadan;
        $berat = $pd->beratbadan;

        // Hitung IMT
        $imt = $berat / pow($tinggi / 100, 2);

        if ($pd->jeniskelamin === 'Laki-laki') {
            $median = 15.5;
            $sd = 1.2;
        } else {
            $median = 15.3;
            $sd = 1.1;
        }

        $z_score = ($imt - $median) / $sd;

        if ($z_score < -2) {
            $status = 'Gizi Kurang';
        } elseif ($z_score >= -2 && $z_score <= 1) {
            $status = 'Gizi Baik';
        } elseif ($z_score > 1 && $z_score <= 2) {
            $status = 'Gizi Lebih';
        } else {
            $status = 'Obesitas';
        }

        return view('statusgizi.create', [
            'pd' => $pd,
            'z_score' => number_format($z_score, 3),
            'status_gizi' => $status
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|exists:pesertadidiks,nisn',
            'z_score' => 'required|numeric',
            'status_gizi' => 'required|string',
        ]);

        Statusgizi::create([
            'nisn' => $request->nisn,
            'z_score' => $request->z_score,
            'status' => $request->status_gizi,
            'tanggalpembuatan' => now(),
        ]);

        return redirect()->route('statusgizi.index')->with('success', 'Status gizi berhasil disimpan.');
    }

    public function destroy($nisn)
    {
        $status = Statusgizi::where('nisn', $nisn)->firstOrFail();
        $status->delete();

        return redirect()->back()->with('success', 'Data status gizi berhasil dihapus.');
    }


    public function index()
    {
        $status = Statusgizi::with('pesertaDidik')->get();
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

        return $pdf->download('Laporan_StatusGizi_' . now()->format('dmY') . '.pdf');
    }

    public function bulkDelete(Request $request)
    {
        $nisns = explode(',', $request->selected_nisn);
        StatusGizi::whereIn('nisn', $nisns)->delete();
        return redirect()->back()->with('success', 'Data yang dipilih berhasil dihapus.');
    }
}
