<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Guru;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getArtikel(){
        $artikels = Artikel::latest()->take(2)->get();
        $gurus = Guru::orderBy('name')->limit(5)->get();
        return view('landingpages', compact('artikels', 'gurus'));
    }

    public function listArtikel(){
        $artikels = Artikel::latest()->get();
        return view('artikel.indexUser', compact('artikels'));
    }
}
