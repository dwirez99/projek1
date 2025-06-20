<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelApiController;
use App\Http\Controllers\Api\OrangtuaApiController;
use App\Http\Controllers\Api\PesertadidikApiController;
use App\Http\Controllers\Api\StatusgiziApiController;
use App\Http\Controllers\Api\UserApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes (no authentication required)
Route::post('/login', [UserApiController::class, 'login'])->name('api.login');
Route::post('/register', [UserApiController::class, 'register'])->name('api.register');

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::get('/user', [UserApiController::class, 'me'])->name('api.user');
    Route::post('/logout', [UserApiController::class, 'logout'])->name('api.logout');
    Route::post('/logout-all', [UserApiController::class, 'logoutAll'])->name('api.logout_all');
    Route::put('/profile', [UserApiController::class, 'updateProfile'])->name('api.profile.update');
    Route::post('/change-password', [UserApiController::class, 'changePassword'])->name('api.change_password');

    // Artikel API Routes
    Route::get('/artikels', [ArtikelApiController::class, 'apiIndex'])->name('api.artikels.index');
    Route::post('/artikels', [ArtikelApiController::class, 'apiStore'])->name('api.artikels.store');
    Route::get('/artikels/{artikel}', [ArtikelApiController::class, 'apiShow'])->name('api.artikels.show');
    Route::put('/artikels/{artikel}', [ArtikelApiController::class, 'apiUpdate'])->name('api.artikels.update');
    Route::patch('/artikels/{artikel}', [ArtikelApiController::class, 'apiUpdate'])->name('api.artikels.patch');
    Route::delete('/artikels/{artikel}', [ArtikelApiController::class, 'apiDestroy'])->name('api.artikels.destroy');

    // Orangtua API Routes
    Route::apiResource('orangtuas', OrangtuaApiController::class)->names('api.orangtuas');

    // Pesertadidik API Routes
    Route::apiResource('pesertadidiks', PesertadidikApiController::class)
        ->parameters(['pesertadidiks' => 'nis'])
        ->names('api.pesertadidiks');

    Route::post('/pesertadidiks/{nis}/upload-penilaian', [PesertadidikApiController::class, 'uploadPenilaian'])
        ->name('api.pesertadidiks.upload_penilaian');

    // StatusGizi API Routes
    Route::apiResource('statusgizi', StatusgiziApiController::class)->names('api.statusgizi');

    // Additional StatusGizi Routes
    Route::post('/statusgizi/calculate', [StatusgiziApiController::class, 'calculate'])->name('api.statusgizi.calculate');
    Route::get('/statusgizi/nis/{nis}', [StatusgiziApiController::class, 'getByNis'])->name('api.statusgizi.by_nis');
    Route::get('/statusgizi/chart/data', [StatusgiziApiController::class, 'chartData'])->name('api.statusgizi.chart_data');
    Route::delete('/statusgizi/bulk-delete', [StatusgiziApiController::class, 'bulkDelete'])->name('api.statusgizi.bulk_delete');
});
