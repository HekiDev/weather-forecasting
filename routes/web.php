<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/place/forecast/{fsq_id}', [HomeController::class, 'placeForecast'])->name('home.forecast');

require __DIR__.'/auth.php';
