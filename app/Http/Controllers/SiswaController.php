<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    // Menampilkan daftar siswa dengan pencarian
    public function daftarsiswa(Request $request)
    {
        $siswa = Siswa::when($request->cari, function($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->cari . '%');
        })->get();
        
        return view('siswa.daftarsiswa', compact('siswa'));
    }

    // Menyimpan data siswa baru
    public function store(Request $request)
    {
        // Validasi input sebelum menyimpan
        $request->validate([
            'nama' => 'required|string|max:255',
            'wali' => 'required|string|max:255',
            'ttl' => 'required|date',
            'jnskelamin' => 'required|string',
            'kelas' => 'required|string',
            'thnajar' => 'required|integer',
            'semester' => 'required|string',
            'tb' => 'required|numeric',
            'bb' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // jika foto diupload
        ]);

        // Menyimpan data siswa baru
        Siswa::create($request->all());

        return redirect('/');
    }

    // Memperbarui data siswa
    public function update(Request $request, $id)
    {
    $siswa = Siswa::findOrFail($id);

    $request->validate([
        'nama' => 'required|string|max:255',
        'wali' => 'required|string|max:255',
        'ttl' => 'required|date',
        'jnskelamin' => 'required|string',
        'kelas' => 'required|string',
        'thnajar' => 'required|integer',
        'semester' => 'required|string',
        'tb' => 'required|numeric',
        'bb' => 'required|numeric',
        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $siswa->update($request->only([
        'nama', 'wali', 'ttl', 'jnskelamin', 'kelas', 'thnajar', 'semester', 'tb', 'bb'
    ]));

    if ($request->hasFile('foto')) {
        if ($siswa->foto && file_exists(public_path('storage/foto/' . $siswa->foto))) {
            unlink(public_path('storage/foto/' . $siswa->foto));
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('storage/foto'), $filename);
        $siswa->foto = $filename;
        $siswa->save();
    }

    return response()->json(['success' => true,'data' => $siswa]);
    }


    // Menghapus data siswa
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Menghapus foto jika ada
        if ($siswa->foto && file_exists(public_path('storage/foto/' . $siswa->foto))) {
            unlink(public_path('storage/foto/' . $siswa->foto));
        }

        // Menghapus data siswa
        $siswa->delete();

        return redirect('/');
    }

    // Menampilkan halaman untuk menghitung Z-Score
    public function zscore($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.zscore', compact('siswa'));
    }
}
