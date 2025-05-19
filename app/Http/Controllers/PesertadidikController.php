<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Orangtua;
use Illuminate\Http\Request;

class PesertadidikController extends Controller
{

    public function index(Request $request)
    {
        $query = Pesertadidik::with('orangtua');

        if($request->has('cari') && !empty($request->cari)) {
            $query->where('namapd', 'like', '%' . $request->cari. '%');
        }

        $pesertadidiks = $query->get();
        // $pesertadidiks = Pesertadidik::with('orangtua')->get();
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

    public function assessments() {
        return $this->hasMany(Assessment::class, 'nisn');
    }
}

