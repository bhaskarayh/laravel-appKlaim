<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClaimController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/claims', [ClaimController::class, 'index']);
Route::post('/claims/export', [ClaimController::class, 'exportToPenampungan'])->name('claims.export');