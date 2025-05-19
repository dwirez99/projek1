<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Orangtua;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesertadidikController extends Controller
{

    public function index(Request $request)
{
    $query = Pesertadidik::with('orangtua');

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
        $validated = $request->validate([
            'nisn' => 'required|unique:pesertadidiks',
            'idortu' => 'required',
            'namapd' => 'required',
            'tanggallahir' => 'required|date',
            'jeniskelamin' => 'required',
            'kelas' => 'required',
            'tahunajar' => 'required',
            'semester' => 'required',
            'tinggibadan' => 'required|integer',
            'beratbadan' => 'required|integer',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $validated['foto'] = $foto;
        }
        Pesertadidik::create($validated);
        return redirect()->route('pesertadidik.index')->with('success', 'Data ditambahkan!');

    }


    public function update(Request $request, $nisn)
    {
        $pesertadidik = Pesertadidik::findOrFail($nisn);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('foto', 'public');
            $data['foto'] = $foto;
        }

        $pesertadidik->update($data);

        return redirect()->back()->with('success', 'Data diperbarui!');
    }

    public function destroy($nisn)
    {
        $pesertadidik = Pesertadidik::findOrFail($nisn);
        $pesertadidik->delete();
        return redirect()->back()->with('success', 'Data dihapus!');
    }
public function uploadPenilaian(Request $request, $nisn)
{
    $request->validate([
        'file_penilaian' => 'required|mimes:pdf,doc,docx|max:2048', // max 2MB
    ]);

    $pd = Pesertadidik::where('nisn', $nisn)->firstOrFail();

    // Hapus file lama jika ada
    if ($pd->file_penilaian && Storage::exists('public/' . $pd->file_penilaian)) {
        Storage::delete('public/' . $pd->file_penilaian);
    }

    // Simpan file baru
    $path = $request->file('file_penilaian')->store('penilaian', 'public');
    $pd->file_penilaian = $path;
    $pd->save();

    return redirect()->back()->with('success', 'File penilaian berhasil diunggah.');
}


}

