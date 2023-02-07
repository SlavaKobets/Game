<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Services\UsersService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guest', 'unique'])->group(function (){

    Route::get('/game/{uuid}', [GameController::class, 'index'])->name('game');

    Route::get('/link/update/{uuid}', [RegisterController::class, 'update'])->name('regenerate');

    Route::get('/link/disable/{uuid}', [RegisterController::class, 'delete'])->name('disable');

    Route::post('/play/{uuid}', [GameController::class, 'play'])->name('play');

    Route::get('/history/{uuid}', [GameController::class, 'history'])->name('history');
});


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


require __DIR__.'/auth.php';
