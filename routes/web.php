<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::namespace('tasks')
    /*->middleware('')*/
    ->name('tasks')
    ->prefix('tasks')
    ->as('tasks.')
    ->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('index');
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::get('/{id}', [TaskController::class, 'show'])->name('show');
        Route::put('/{id}', [TaskController::class, 'update'])->name('update');
        Route::delete('/{id}', [TaskController::class, 'destroy'])->name('destroy');
    });
