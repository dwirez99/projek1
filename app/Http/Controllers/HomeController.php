<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Statusgizi;
use App\Models\Guru;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getArtikel(){
        $artikels = Artikel::latest()->take(4)->get();
        $gurus = Guru::orderBy('name')->limit(5)->get();
        $status = Statusgizi::latest()->get();
        return view('landingpages', compact('artikels', 'gurus','status'));
    }

    public function listArtikel(){
        $artikels = Artikel::latest()->get();
        return view('artikel.indexUser', compact('artikels'));
    }

}
