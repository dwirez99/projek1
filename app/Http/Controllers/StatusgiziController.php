<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Statusgizi;
use Illuminate\Http\Request;

class StatusgiziController extends Controller
{
    public function create($nisn)
    {
        $pd = Pesertadidik::findOrFail($nisn);
        return view('statusgizi.create', compact('pd'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nisn' => 'required|exists:pesertadidiks,nisn',
    ]);

    $pd = Pesertadidik::where('nisn', $request->nisn)->first();

    $tinggi = $pd->tinggibadan;
    $berat = $pd->beratbadan;

    $ideal = ($tinggi - 100) * 0.9;
    $z_score = ($berat - $ideal) / 2; // asumsi SD = 2

    if ($z_score < -2) {
        $status = 'Kurang Gizi';
    } elseif ($z_score > 2) {
        $status = 'Gizi Lebih';
    } else {
        $status = 'Normal';
    }

    // Simpan ke database
    $statusgizi = Statusgizi::create([
        'nisn' => $request->nisn,
        'z_score' => round($z_score, 2),
        'status' => $status,
        'tanggalpembuatan' => now(),
    ]);

    // Kembali ke halaman create dengan data hasil
    return view('statusgizi.create', [
        'pd' => $pd,
        'z_score' => round($z_score, 2),
        'status_gizi' => $status
    ]);
}


    public function index()
    {
        $status = StatusGizi::with('pesertaDidik')->get();
        return view('statusgizi.index', compact('status'));
    }
}
