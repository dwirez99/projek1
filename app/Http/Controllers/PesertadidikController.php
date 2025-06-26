<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\DB;

class PesertadidikController extends Controller
{

    public function index(Request $request)
    {
        $query = Pesertadidik::with('orangtua','statusgiziTerbaru');

        // Pencarian Nama
        if ($request->filled('cari')) {
            $query->where('namapd', 'like', '%' . $request->cari . '%');
        }

        // Filter Kelas
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        // Filter Tahun Ajar
        if ($request->filled('tahunajar')) {
            $query->where('tahunajar', $request->tahunajar);
        }



        // Sorting Nama
        if ($request->sort == 'nama_asc') {
            $query->orderBy('namapd', 'asc');
        } elseif ($request->sort == 'nama_desc') {
            $query->orderBy('namapd', 'desc');
        } else {
            $query->orderBy('namapd', 'asc'); // Default
        }

        if ($request->status == 'False'){
            $query->leftJoin('statusgizis', 'pesertadidiks.nis', '=', 'statusgizis.nis')
        ->whereNull('statusgizis.status')
        ->select('pesertadidiks.*') // pilih kolom yang diperlukan
        ->get();
        } elseif ($request->status == 'True') {
            $query->leftJoin('statusgizis', 'pesertadidiks.nis', '=', 'statusgizis.nis')
        ->whereNotNull('statusgizis.status')
        ->select('pesertadidiks.*') // pilih kolom yang diperlukan
        ->get();
        } else {
            $query->get();
        }

        $pesertadidiks = $query->paginate(5);
        $orangtuas = Orangtua::all();

        return view('pesertadidik.index', compact('pesertadidiks', 'orangtuas'));
    }


    public function create()
    {
        $orangtuas = Orangtua::all();
        return view('pesertadidik.create', compact('orangtuas'));
    }


    public function store(Request $request)
    {
        try {
            Log::info('Memulai proses penyimpanan peserta didik.', ['request_data' => $request->all()]);

            $validated = $request->validate([
                'idortu' => 'required',
                'namapd' => 'required',
                'tanggallahir' => 'required|date',
                'jeniskelamin' => 'required',
                'kelas' => 'required',
                'tinggibadan' => 'required|integer',
                'beratbadan' => 'required|integer',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                // tambahkan validasi tahunajar dan semester kalau diperlukan
            ]);
            // Generate NIS sebagai angka acak unik
            do {
                $nis = random_int(1000000000, 9999999999); // 10 digit
            } while (DB::table('pesertadidiks')->where('nis', $nis)->exists());

            Log::info("Generated NIS: " . $nis);
            $validated['nis'] = $nis;

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto', $filename, 'public');
                $validated['foto'] = $path; // Store the full path including folder

                Log::info('Foto berhasil diupload.', ['path' => $path]);
            }

            $pd = PesertaDidik::create($validated);

            Log::info('Data peserta didik berhasil disimpan.', ['id' => $pd->nis]);

            return redirect()->route('pesertadidik.index')->with('success', 'Data ditambahkan!');
        } catch (Exception $e) {
            Log::error('Gagal menyimpan data peserta didik.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors('Terjadi kesalahan saat menyimpan data.')->withInput();
        }
    }




    public function update(Request $request, $nis)
    {
        try {
            $pesertadidik = Pesertadidik::findOrFail($nis);

            $data = $request->all();

            if ($request->hasFile('foto')) {
                // Delete old file if exists
                if ($pesertadidik->foto && Storage::exists('public/' . $pesertadidik->foto)) {
                    Storage::delete('public/' . $pesertadidik->foto);
                    Log::info("Foto lama dihapus untuk NIS: $nis");
                }

                // Store new file
                $file = $request->file('foto');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('foto', $filename, 'public');
                $data['foto'] = $path;

                Log::info("Foto baru berhasil diunggah ke: $path untuk NIS: $nis");
            }

            $pesertadidik->update($data);

            return redirect()->back()->with('success', 'Data diperbarui!');
        } catch (Exception $e) {
            Log::error('Gagal memperbarui data peserta didik.', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->withErrors('Terjadi kesalahan saat memperbarui data.')->withInput();
        }
    }

    public function destroy($nis)
    {
        $pesertadidik = Pesertadidik::findOrFail($nis);
        $pesertadidik->delete();
        return redirect()->back()->with('success', 'Data dihapus!');
    }

    public function uploadPenilaian(Request $request, $nis)
    {
        Log::info('Proses unggah dimulai untuk NIS: ' . $nis);

        try {
            // Validasi file input
            $request->validate([
                'file' => 'required|file|mimes:pdf,docx,doc,xlsx|max:10240',
            ]);
            Log::info("Validasi berhasil untuk NIS: $nis");

            if ($request->hasFile('file')) {
                // Ambil data peserta didik
                $pd = Pesertadidik::where('nis', $nis)->first();

                if (!$pd) {
                    Log::warning("Peserta didik dengan NIS $nis tidak ditemukan.");
                    return redirect()->back()->withErrors(['file' => 'Peserta didik tidak ditemukan.']);
                }

                // Hapus file lama jika ada
                if ($pd->file_penilaian && Storage::exists('public/' . $pd->file_penilaian)) {
                    Storage::delete('public/' . $pd->file_penilaian);
                    Log::info("File lama dihapus untuk NIS: $nis, path: public/{$pd->file_penilaian}");
                } else {
                    Log::info("Tidak ada file lama untuk NIS: $nis");
                }

                // Simpan file baru
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('penilaian', $filename, 'public');

                Log::info("File baru berhasil diunggah ke: $path");

                // Simpan path ke database
                $pd->file_penilaian = $path;
                $pd->save();

                Log::info("Path file disimpan di kolom file_penilaian untuk NIS: $nis");

                return redirect()->back()->with('success', 'File berhasil diunggah dan disimpan!');
            } else {
                Log::warning("Tidak ada file yang dikirim pada form upload untuk NIS: $nis");
                return redirect()->back()->withErrors(['file' => 'File tidak ditemukan.']);
            }
        } catch (ValidationException $e) {
            Log::error("Validasi gagal untuk NIS $nis: " . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error("Terjadi kesalahan saat upload untuk NIS $nis: " . $e->getMessage());
            return redirect()->back()->withErrors(['file' => 'Gagal mengunggah file.']);
        }
    }
}
