<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('tests')->group(function () {
    Auth::routes();

    Route::middleware('guest')->get('/', function () {
        return view('welcome');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('test')->middleware(['auth'])->as('test')->group(function () {
        Route::get('start', [App\Http\Controllers\TestsController::class, 'index'])->name('.init');
        Route::post('answer/question/{question}', [App\Http\Controllers\TestsController::class, 'answer'])->name('.answer');
    });

    Route::prefix('view-result')->middleware(['auth'])->as('view-result')->group(function () {
        Route::get('', [App\Http\Controllers\ViewResultController::class, 'index'])->name('.home');
    });

    Route::prefix('test')->middleware(['auth'])->as('test')->group(function () {
        Route::get('/', [App\Http\Controllers\TestsController::class, 'test'])->name('.start');
    });

});
