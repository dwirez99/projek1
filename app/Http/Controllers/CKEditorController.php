<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('storage/uploads'); // Simpan di storage/app/public/uploads
            $url = Storage::url($path); // hasilnya: /storage/uploads/namafile.jpg

            return response()->json([
                'url' => $url
            ]);
        }

        return response()->json(['error' => 'Tidak ada file yang diunggah.'], 400);
    }
}







