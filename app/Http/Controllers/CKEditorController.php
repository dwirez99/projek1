<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        Log::info('CKEditor upload request:', $request->all());

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');

            Log::info('File info:', [
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize()
            ]);

            $path = $file->store('uploads', 'public'); // Simpan file

            // 👇 Respons sesuai standar CKEditor 5
            return response()->json([
                'uploaded' => 1,
                'fileName' => basename($path),
                'url' => asset('storage/' . $path)
            ]);
        }

        Log::error('Upload gagal: file tidak ditemukan.');
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Upload gagal']], 400);
    }
}




