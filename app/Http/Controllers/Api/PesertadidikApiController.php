<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pesertadidik;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class PesertadidikApiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesertadidik::with('orangtua', 'statusgiziTerbaru');

        if ($request->filled('cari')) {
            $query->where('namapd', 'like', '%' . $request->cari . '%');
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('tahunajar')) {
            $query->where('tahunajar', $request->tahunajar);
        }

        if ($request->sort == 'nama_asc') {
            $query->orderBy('namapd', 'asc');
        } elseif ($request->sort == 'nama_desc') {
            $query->orderBy('namapd', 'desc');
        } else {
            $query->orderBy('namapd', 'asc');
        }

        $pesertadidiks = $query->paginate(20);
        $orangtuas = Orangtua::all();

        return response()->json([
            'pesertadidiks' => $pesertadidiks,
            'orangtuas' => $orangtuas
        ]);
    }

    private function uploadFoto(Request $request)
    {
        if ($request->hasFile('foto')) {
            // Simpan file ke folder 'foto' di storage/app/public/foto
            return $request->file('foto')->store('foto', 'public');
        }
        return null;
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'idortu' => 'required',
                'namapd' => 'required',
                'tanggallahir' => 'required|date',
                'jeniskelamin' => 'required',
                'kelas' => 'required',
                'tinggibadan' => 'required|integer',
                'beratbadan' => 'required|integer',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            do {
                $nis = random_int(1000000000, 9999999999);
            } while (DB::table('pesertadidiks')->where('nis', $nis)->exists());

            $validated['nis'] = $nis;

            $fotoPath = $this->uploadFoto($request);
            if ($fotoPath) {
                $validated['foto'] = $fotoPath;
            }

            $pd = Pesertadidik::create($validated);

            return response()->json([
                'message' => 'Data peserta didik berhasil ditambahkan.',
                'data' => $pd
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal menyimpan data peserta didik.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $nis)
    {
        $pesertadidik = Pesertadidik::findOrFail($nis);
        $data = $request->all();

        $fotoPath = $this->uploadFoto($request);
        if ($fotoPath) {
            $data['foto'] = $fotoPath;
        }

        $pesertadidik->update($data);

        return response()->json(['message' => 'Data diperbarui!', 'data' => $pesertadidik]);
    }

    public function destroy($nis)
    {
        $pesertadidik = Pesertadidik::findOrFail($nis);
        $pesertadidik->delete();
        return response()->json(['message' => 'Data dihapus!']);
    }

    public function uploadPenilaian(Request $request, $nis)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,xlsx|max:10240',
            ]);

            if ($request->hasFile('file')) {
                $pd = Pesertadidik::where('nis', $nis)->first();

                if (!$pd) {
                    return response()->json(['error' => 'Peserta didik tidak ditemukan.'], 404);
                }

                if ($pd->file_penilaian && Storage::exists('public/' . $pd->file_penilaian)) {
                    Storage::delete('public/' . $pd->file_penilaian);
                }

                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('penilaian', $filename, 'public');

                $pd->file_penilaian = $path;
                $pd->save();

                return response()->json(['message' => 'File berhasil diunggah dan disimpan!']);
            } else {
                return response()->json(['error' => 'File tidak ditemukan.'], 400);
            }
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Gagal mengunggah file.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
