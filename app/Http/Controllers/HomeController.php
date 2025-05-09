<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getArtikel(){
        $artikels = Artikel::latest()->take(2)->get();
        return view('landingpages', compact('artikels'));
    }

    public function listArtikel(){
        $artikels = Artikel::latest()->get();
        return view('artikel.indexUser', compact('artikels'));
    }
}
