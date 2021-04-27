<?php

use Illuminate\Support\Facades\Route;
use Admin\AdminController;

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
    })->name('welcome');
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

    ///////////////////////// Admin

    Route::get('admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])
        ->middleware(['auth', 'admin'])
        ->name('admin-nav');

    Route::get('confirmation', [App\Http\Controllers\Admin\AdminController::class, 'confirmationRegistrationForm'])
        ->middleware(['auth', 'admin'])
        ->name('confirmation-form');

    Route::post('confirmation-registration', [App\Http\Controllers\Admin\AdminController::class, 'confirmationRegistration'])
        ->middleware(['auth', 'admin'])
        ->name('confirmation-registration');

    Route::get('results', [App\Http\Controllers\Admin\AdminController::class, 'resultsForm'])
        ->middleware(['auth', 'admin'])
        ->name('results-form');

    Route::get('students-filter', [App\Http\Controllers\Admin\AdminController::class, 'filterStudents'])
        ->middleware(['auth', 'admin'])
        ->name('students-filter');
        
    Route::get('tests-list/{user_id}', [App\Http\Controllers\Admin\AdminController::class, 'studentsTestsForm'])
        ->middleware(['auth', 'admin'])
        ->name('tests-list');

    Route::post('confirm-test', [App\Http\Controllers\Admin\AdminController::class, 'studentTestConfirm'])
        ->middleware(['auth', 'admin'])
        ->name('confirm-test');

});
