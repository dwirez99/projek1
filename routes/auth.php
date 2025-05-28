<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Volt::route('login', 'auth.login')
        ->name('login');

});

use App\Http\Controllers\OrangtuaController;

Route::middleware('role:orangtua')->group(function () {
    Route::get('editprofiles', [OrangtuaController::class, 'editProfile'])
        ->name('editprofiles');

    Route::post('editprofiles/update', [OrangtuaController::class, 'updateProfile']) // Handle profile updates
        ->name('editprofiles.update');

    // Fallback POST route to handle incorrect POST to userprofiles
    Route::post('editrofiles', function () {
        return redirect()->route('userprofiles')->with('error', 'POST method not supported on this route. Please use the update route.');
    });

    // New route for read-only profile view
    Route::get('orangtuas/profiles', [OrangtuaController::class, 'showReadOnlyProfile'])
        ->name('orangtuas.profiles');
});

Route::post('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');

    // Route::middleware(['auth', 'role:guru'])->group(function () {
    //     Route::get('/', function () {
    //         return view('landingpages');
    //     })->name('dashboard');
    // });

    // Route::middleware(['auth', 'role:orangtua'])->group(function () {
    //     Route::get('/', function () {
    //         return view('landingpages');
    //     })->name('landingpages');
    // });

    use App\Http\Controllers\HomeController;

    Route::get('/landingpages', [HomeController::class, 'getArtikel'])->name('landingpages');

    // Route::middleware(['auth', 'role:guest'])->group(function () {
    //     Route::get('/landingpages', function () {
    //         return view('landingpages');
    //     })->name('landingpages');
    // });

