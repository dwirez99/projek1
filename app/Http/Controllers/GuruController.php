<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guru;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class GuruController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('can:manage-guru', except: ['index']),
        ];
    }

    public function index(Request $request)
    {
        $query = Guru::query();

        // Filter pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Ambil hanya 5 guru
        $gurus = $query->orderBy('name')->limit(5)->get();

        return view('guru.index', compact('gurus'));
    }
}
