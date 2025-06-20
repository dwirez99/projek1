<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArtikelApiController extends Controller
{
    /**
     * Display a listing of the resource for API.
     */
    public function apiIndex(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $artikels = Artikel::latest()->paginate($perPage);
        return response()->json($artikels);
    }

    /**
     * Store a newly created resource in storage for API.
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only('judul', 'konten');

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $path = $file->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

        $artikel = Artikel::create($data);

        return response()->json($artikel, 201);
    }

    /**
     * Display the specified resource for API.
     */
    public function apiShow(Artikel $artikel)
    {
        return response()->json($artikel);
    }

    /**
     * Update the specified resource in storage for API.
     */
    public function apiUpdate(Request $request, Artikel $artikel)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'sometimes|required|string|max:255',
            'konten' => 'sometimes|required|string',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $request->only('judul', 'konten');

        if ($request->hasFile('thumbnail')) {
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $file = $request->file('thumbnail');
            $path = $file->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        } elseif ($request->exists('thumbnail') && is_null($request->input('thumbnail'))) {
            // If 'thumbnail' is explicitly sent as null, remove it
            if ($artikel->thumbnail) {
                Storage::disk('public')->delete($artikel->thumbnail);
            }
            $data['thumbnail'] = null;
        }

        $artikel->update($data);
        return response()->json($artikel->fresh()); // Return fresh model
    }

    /**
     * Remove the specified resource from storage for API.
     */
    public function apiDestroy(Artikel $artikel)
    {
        if ($artikel->thumbnail) {
            Storage::disk('public')->delete($artikel->thumbnail);
        }
        $artikel->delete();
        return response()->json(null, 204);
    }
}
