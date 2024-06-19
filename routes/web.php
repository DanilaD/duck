<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DuckController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DuckController::class, 'index'])->name('ducks.index');
Route::post('/search', [DuckController::class, 'search'])->name('ducks.search');
Route::post('/ages', [DuckController::class, 'ages'])->name('ducks.ages');
Route::get('/edit/{id}', [DuckController::class, 'edit'])->name('ducks.edit');
Route::put('/store/{id}', [DuckController::class, 'update'])->name('ducks.update');
Route::post('/destroy/{id}', [DuckController::class, 'destroy'])->name('ducks.destroy');
