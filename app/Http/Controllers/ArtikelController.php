<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artikels = Artikel::latest()->paginate(5); // Mengubah get() menjadi paginate(), misalnya 5 item per halaman
        return view('artikel.index', compact('artikels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'

        ]);

        $data = $request->only('judul','konten');

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $path = $file->store('thumbnails','public');
            $data['thumbnail'] = $path;
        }

        Artikel::create($data);

        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        return view('artikel.show',compact('artikel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        return view('artikel.edit', compact('artikel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048' // Consistent with store
        ]);

        $data = $request->only('judul','konten');

        if ($request->hasFile('thumbnail')){
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails','public');
        }

        $artikel->update($data);
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil diperbarui');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return redirect()->route('artikel.index')->with('success', 'Artikel berhasil dihapus');

    }
}
