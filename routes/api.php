<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('bot-details',[\App\Http\Controllers\ApiCOntroller::class,'index']);
Route::post('incoming',[\App\Http\Controllers\ApiCOntroller::class,'incoming']);
Route::post('ocr/callback',[\App\Http\Controllers\ApiCOntroller::class,'ocrCallback'])->name('ocr-callback');
Route::get('test',[\App\Http\Controllers\ApiCOntroller::class,'test'])->name('test');
Route::any('whatsapp-incoming',[\App\Http\Controllers\ApiCOntroller::class,'whatsappIncoming'])->name('whatsappIncoming');
Route::post('thumb-logs',[\App\Http\Controllers\ApiCOntroller::class,'thumbLogs'])->name('thumbLogs');
Route::get('phpinfo', fn () => phpinfo());
