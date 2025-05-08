<?php

<<<<<<< HEAD
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\CKEditorController;
=======
use App\Http\Controllers\PesertadidikController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\StatusgiziController;
>>>>>>> a8f20bb (Revamp dan Statusgizi)
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('landingpages');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

<<<<<<< HEAD
//SISWA>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Route::get('/siswas', [SiswaController::class, 'daftarsiswa']);
Route::post('/siswa', [SiswaController::class, 'store']);
Route::put('/siswa/{id}', [SiswaController::class, 'update']);
Route::delete('/siswa/{id}', [SiswaController::class, 'destroy']);
Route::get('/siswa/zscore/{id}', [SiswaController::class, 'zscore']);
=======
//Pesertadidik..
Route::get('/pesertadidik', [PesertadidikController::class, 'index'])->name('pesertadidik.index');
Route::get('/pesertadidik/create', [PesertadidikController::class, 'create'])->name('pesertadidik.create');
Route::post('/pesertadidik', [PesertadidikController::class, 'store'])->name('pesertadidik.store');
Route::patch('/pesertadidik/{nisn}', [PesertadidikController::class, 'update'])->name('pesertadidik.update');
Route::delete('/pesertadidik/{nisn}', [PesertadidikController::class, 'destroy'])->name('pesertadidik.destroy');

// StatusgiziController..
Route::get('/statusgizi', [StatusgiziController::class, 'index'])->name('statusgizi.index');
Route::get('/statusgizi/create/{nisn}', [StatusgiziController::class, 'create'])->name('statusgizi.create');
Route::post('/statusgizi', [StatusgiziController::class, 'store'])->name('statusgizi.store');
>>>>>>> a8f20bb (Revamp dan Statusgizi)

require __DIR__.'/auth.php';


//ARTIKEL>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Route::get('artikels', [ArtikelController::class, 'index']);
Route::resource('artikel', ArtikelController::class);
Route::post('/ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');