<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Statusgizi;
use App\Models\Pesertadidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StatusgiziApiController extends Controller
{
    /**
     * Get all status gizi records
     */
    public function index(Request $request)
    {
        try {
            $query = Statusgizi::with('pesertadidik');

            // Filter by status
            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            // Filter by date range
            if ($request->has('tanggal_mulai')) {
                $query->whereDate('tanggalpembuatan', '>=', $request->tanggal_mulai);
            }
            if ($request->has('tanggal_selesai')) {
                $query->whereDate('tanggalpembuatan', '<=', $request->tanggal_selesai);
            }

            // Filter by kelas (through pesertadidik relationship)
            if ($request->has('kelas')) {
                $query->whereHas('pesertadidik', function($q) use ($request) {
                    $q->where('kelas', $request->kelas);
                });
            }

            // Pagination
            $Statusgizi = $query->orderBy('tanggalpembuatan', 'desc');

            return response()->json($Statusgizi);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve status gizi data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new status gizi record
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nis' => 'required|exists:pesertadidiks,nis',
                'z_score' => 'required|numeric',
                'status' => 'required|string|in:Gizi Kurang,Gizi Baik,Gizi Lebih,Obesitas',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            $Statusgizi = Statusgizi::create([
                'nis' => $request->nis,
                'z_score' => $request->z_score,
                'status' => $request->status,
                'tanggalpembuatan' => now(),
            ]);

            return response()->json([
                'message' => 'Status gizi berhasil disimpan',
                'data' => $Statusgizi->load('pesertadidik')
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create status gizi',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show specific status gizi record
     */
    public function show($id)
    {
        try {
            $Statusgizi = Statusgizi::with('pesertadidik')->findOrFail($id);
            return response()->json(['data' => $Statusgizi]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Status gizi not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update status gizi record
     */
    public function update(Request $request, $id)
    {
        try {
            $Statusgizi = Statusgizi::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nis' => 'sometimes|exists:pesertadidiks,nis',
                'z_score' => 'sometimes|numeric',
                'status' => 'sometimes|string|in:Gizi Kurang,Gizi Baik,Gizi Lebih,Obesitas',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            $Statusgizi->update($request->only(['nis', 'z_score', 'status']));

            return response()->json([
                'message' => 'Status gizi berhasil diupdate',
                'data' => $Statusgizi->load('pesertadidik')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update status gizi',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete status gizi record
     */
    public function destroy($id)
    {
        try {
            $Statusgizi = Statusgizi::findOrFail($id);
            $Statusgizi->delete();

            return response()->json([
                'message' => 'Status gizi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete status gizi',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate and store status gizi for a peserta didik
     */
    public function calculate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nis' => 'required|exists:pesertadidiks,nis',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            $pd = Pesertadidik::where('nis', $request->nis)->first();

            $tinggi = $pd->tinggibadan;
            $berat = $pd->beratbadan;
            $jeniskelamin = $pd->jeniskelamin;

            // Calculate IMT
            $imt = $berat / pow($tinggi / 100, 2);

            // Calculate age in years and months
            $lahir = Carbon::parse($pd->tanggallahir);
            $sekarang = Carbon::now();
            $umur = $lahir->diff($sekarang);

            $umurTahun = $umur->y;
            $umurBulan = $umur->m;
            $umurKey = $umurTahun . '-' . $umurBulan;

            // WHO standards data (same as in your controller)
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
                return response()->json([
                    'error' => 'Age data not available',
                    'message' => "Data standar untuk umur $umurKey belum tersedia"
                ], 400);
            }

            $dataStandar = $standar[$jeniskelamin][$umurKey];
            $median = $dataStandar['median'];
            $minus1sd = $dataStandar['-1sd'];
            $plus1sd = $dataStandar['+1sd'];

            // Calculate SD based on direction
            if ($imt < $median) {
                $sd = $median - $minus1sd;
            } else {
                $sd = $plus1sd - $median;
            }

            // Calculate Z-Score
            $z_score = ($imt - $median) / $sd;

            // Determine nutritional status
            if ($z_score < -2) {
                $status = 'Gizi Kurang';
            } elseif ($z_score >= -2 && $z_score <= 1) {
                $status = 'Gizi Baik';
            } elseif ($z_score > 1 && $z_score <= 2) {
                $status = 'Gizi Lebih';
            } else {
                $status = 'Obesitas';
            }

            return response()->json([
                'peserta_didik' => $pd,
                'calculation' => [
                    'imt' => round($imt, 2),
                    'umur' => [
                        'tahun' => $umurTahun,
                        'bulan' => $umurBulan
                    ],
                    'z_score' => round($z_score, 3),
                    'status_gizi' => $status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Calculation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get status gizi by NIS
     */
    public function getByNis($nis)
    {
        try {
            $Statusgizi = Statusgizi::with('pesertadidik')
                ->where('nis', $nis)
                ->orderBy('tanggalpembuatan', 'desc')
                ->get();

            return response()->json(['data' => $Statusgizi]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve status gizi',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get chart data for status gizi
     */
    public function chartData(Request $request)
    {
        try {
            $bulan = $request->get('bulan', now()->format('Y-m'));

            $data = Statusgizi::with('pesertadidik')
                ->whereRaw('DATE_FORMAT(tanggalpembuatan, "%Y-%m") = ?', [$bulan])
                ->get();

            $kelasA = ['Gizi Kurang' => 0, 'Gizi Baik' => 0, 'Gizi Lebih' => 0, 'Obesitas' => 0];
            $kelasB = ['Gizi Kurang' => 0, 'Gizi Baik' => 0, 'Gizi Lebih' => 0, 'Obesitas' => 0];

            foreach ($data as $item) {
                $status = $item->status;
                $kelas = $item->pesertadidik->kelas ?? 'A';

                if (!in_array($status, ['Gizi Kurang', 'Gizi Baik', 'Gizi Lebih', 'Obesitas'])) continue;

                if ($kelas === 'A') {
                    $kelasA[$status]++;
                } elseif ($kelas === 'B') {
                    $kelasB[$status]++;
                }
            }

            return response()->json([
                'bulan' => $bulan,
                'data' => [
                    'kelasA' => $kelasA,
                    'kelasB' => $kelasB
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate chart data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk delete status gizi records
     */
    public function bulkDelete(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'ids' => 'required|array',
                'ids.*' => 'integer|exists:status_gizis,idstatus'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'Validation failed',
                    'messages' => $validator->errors()
                ], 422);
            }

            $deletedCount = Statusgizi::whereIn('idstatus', $request->ids)->delete();

            return response()->json([
                'message' => "Berhasil menghapus $deletedCount data status gizi"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Bulk delete failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
