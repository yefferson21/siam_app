<?php

use App\Http\Controllers\CierreMensualController;
use Illuminate\Support\Facades\Route;
use App\Jobs\CierreMensual;


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

Route::get('/x', function () {
    return view('inicio');
});


Route::get('/cierre',[CierreMensualController::class, 'index']);

Route::get('/apertura',[CierreMensualController::class, 'apertura']);