<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Assessment;
use App\Models\AssessmentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssesmentController extends Controller // Perbaikan typo nama class
{
    // Menampilkan daftar peserta didik
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pesertaDidik = Pesertadidik::with('assessments')
            ->when($search, function ($query) use ($search) {
                $query->where('namapd', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");
            })
            ->orderBy('kelas')
            ->orderBy('namapd')
            ->paginate(20);

        return view('assessments.index', compact('pesertaDidik', 'search'));
    }

    // Menampilkan form penilaian
    public function create($nisn)
    {
        $peserta = Pesertadidik::findOrFail($nisn);
        return view('assessments.create', compact('peserta'));
    }

    // Menampilkan history penilaian
    public function show($nisn)
    {
        $peserta = Pesertadidik::with(['assessments.details'])
                     ->findOrFail($nisn);

        return view('assessments.show', compact('peserta'));
    }

    // Menyimpan penilaian baru
    public function store(Request $request)
{
    // Debug incoming request (remove after testing)
    // dd($request->all());

    $validated = $request->validate([
        'nisn' => 'required|exists:pesertadidiks,nisn',
        'indicators' => 'required|array',
        'comments' => 'sometimes|array'
    ]);

    try {
        DB::beginTransaction();

        // Create main assessment record
        $assessment = Assessment::create([
            'nisn' => $request->nisn,
            'teacher_id' => auth()->id(),
            'assessment_date' => now(),
            'notes' => $request->general_notes ?? null
        ]);

        // Process indicators
        foreach ($request->indicators as $aspect => $indicators) {
            foreach ($indicators as $indicator => $score) {
                AssessmentDetail::create([
                    'assessment_id' => $assessment->id,
                    'aspect' => $aspect,
                    'indicator' => $indicator,
                    'score' => $score,
                    'comment' => $request->comments[$aspect][$indicator] ?? null
                ]);
            }
        }

        DB::commit();

        return redirect()->route('assessments.show', $request->nisn)
                        ->with('success', 'Penilaian berhasil disimpan!');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()
                    ->with('error', 'Gagal menyimpan: ' . $e->getMessage());
    }
}
}