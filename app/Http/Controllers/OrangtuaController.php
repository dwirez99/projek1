<?php

namespace App\Http\Controllers;

use App\Models\Orangtua;
use Illuminate\Http\Request;

class OrangtuaController extends Controller
{
    public function index()
    {
        $orangtuas = Orangtua::all();
        return view('orangtua.index', compact('orangtuas'));
    }

    public function create()
    {
        return view('orangtua.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'namaortu' => 'required|string|max:255',
            'notelportu' => 'required|string|max:15',
            'emailortu' => 'required|email',
        ]);

        Orangtua::create($validatedData);
        return redirect()->route('orangtua.index')->with('success', 'Orang Tua berhasil ditambahkan!');
    }

    public function edit(Orangtua $orangtua)
    {
        return view('orangtua.edit', compact('orangtua'));
    }

    public function update(Request $request, Orangtua $orangtua)
    {
        $validatedData = $request->validate([
            'namaortu' => 'required|string|max:255',
            'notelportu' => 'required|string|max:15',
            'emailortu' => 'required|email',
        ]);

        $orangtua->update($validatedData);
        return redirect()->route('orangtua.index')->with('success', 'Orang Tua berhasil diperbarui!');
    }

    public function destroy(Orangtua $orangtua)
    {
        $orangtua->delete();
        return redirect()->route('orangtua.index')->with('success', 'Orang Tua berhasil dihapus!');
    }
}