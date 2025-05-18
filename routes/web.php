<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\CKEditorController;
use App\Http\Controllers\PesertadidikController;
use App\Http\Controllers\StatusgiziController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\AssesmentController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard;
use App\Models\Artikel;

Route::get('/', [HomeController::class, 'getArtikel']);
// Route::get('/', function () {
//     return view('landingpages');
// })->name('home');

Route::get('/',[HomeController::class, 'getArtikel'])->name('home');



Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/statusgiziOrtu', [StatusgiziController::class, 'indexOrtu'])->name('statusOrtu.index');
});

//Orang Tua
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/orangtuas', [OrangtuaController::class, 'index'])->name('orangtua.index');
    Route::get('/orangtuas/create', [OrangtuaController::class, 'create'])->name('orangtua.create');
    Route::post('/orangtuas', [OrangtuaController::class, 'store'])->name('orangtua.store');
    Route::patch('/orangtuas/{id}', [OrangtuaController::class, 'update'])->name('orangtua.update');
    Route::delete('orangtuas/{orangtua}', [OrangtuaController::class, 'destroy'])->name('orangtua.destroy');
});

// Pesertadidik..
Route::get('/pesertadidik', [PesertadidikController::class, 'index'])->name('pesertadidik.index');
Route::get('/pesertadidik/create', [PesertadidikController::class, 'create'])->name('pesertadidik.create');
Route::post('/pesertadidik', [PesertadidikController::class, 'store'])->name('pesertadidik.store');
Route::patch('/pesertadidik/{nisn}', [PesertadidikController::class, 'update'])->name('pesertadidik.update');
Route::delete('/pesertadidik/{nisn}', [PesertadidikController::class, 'destroy'])->name('pesertadidik.destroy');
//Pesertadidik..
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/pesertadidik', [PesertadidikController::class, 'index'])->name('pesertadidik.index');
    Route::get('/pesertadidik/create', [PesertadidikController::class, 'create'])->name('pesertadidik.create');
    Route::post('/pesertadidik', [PesertadidikController::class, 'store'])->name('pesertadidik.store');
    Route::patch('/pesertadidik/{nisn}', [PesertadidikController::class, 'update'])->name('pesertadidik.update');
    Route::delete('/pesertadidik/{nisn}', [PesertadidikController::class, 'destroy'])->name('pesertadidik.destroy');
});

// Statusgizi..
Route::prefix('statusgizi')->name('statusgizi.')->group(function () {
    Route::get('/', [StatusgiziController::class, 'index'])->name('index');
    Route::get('/create/{nisn}', [StatusgiziController::class, 'create'])->name('create');
    Route::post('/hitung', [StatusgiziController::class, 'hitung'])->name('hitung');
    Route::post('/store', [StatusgiziController::class, 'store'])->name('store');
    Route::delete('/bulk-delete', [StatusgiziController::class, 'bulkDelete'])->name('bulkDelete');
    Route::delete('/{nisn}', [StatusgiziController::class, 'destroy'])->name('destroy');
    Route::get('/export-pdf', [StatusgiziController::class, 'exportPdf'])->name('exportPdf');
});

// Artikel
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/artikels', [ArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikels/create', [ArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikels', [ArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikels/{artikel}/edit', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikels/{artikel}', [ArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikels/{artikel}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');

    Route::post('/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');
});


// Nilai peserta didik
Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/assessments', [AssesmentController::class, 'index'])->name('assessments.index');
    Route::get('/assessments/create/{nisn}', [AssesmentController::class, 'create'])->name('assessments.create');
    Route::get('/assessments/{nisn}', [AssesmentController::class, 'show'])->name('assessments.show');
    Route::post('/assessments', [AssesmentController::class, 'store'])->name('assessment.store');
    Route::delete('/assessments/{id}', [AssesmentController::class, 'destroy'])->name('assessments.destroy');

});

Route::middleware(['auth', 'role:orangtua'])->group(function () {
    Route::get('/penilaian/conclusion', [AssesmentController::class, 'conclusionIndex'])->name('penilaian.conclusion.index');
    Route::get('/penilaian/conclusion/{nisn}', [AssesmentController::class, 'conclusion'])->name('penilaian.conclusion');
    Route::get('/penilaian/conclusion/{nisn}/pdf', [AssesmentController::class, 'exportConclusionPdf'])->name('penilaian.conclusion.pdf');
    Route::get('/assessments/{nisn}', [AssesmentController::class, 'show'])->name('assessments.show');


});


Route::get('/artikels/{artikel}', [ArtikelController::class, 'show'])->name('artikel.show');
Route::get('/kegiatan', [HomeController::class, 'listArtikel'])->name('listArtikel');

require __DIR__ . '/auth.php';
