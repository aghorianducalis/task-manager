<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::namespace('pages')
    ->name('pages')
    ->as('pages.')
    ->group(function () {

        Route::get('/', [PageController::class, 'welcome'])->name('welcome');

        Route::middleware('auth')
            ->group(function () {
                Route::get('/home', [PageController::class, 'home'])->name('home');

                Route::namespace('tasks')
                    ->name('tasks')
                    ->prefix('tasks')
                    ->as('tasks.')
                    ->group(function () {
                        Route::get('/', [PageController::class, 'taskIndex'])->name('index');
                        Route::get('/show/{id}', [PageController::class, 'taskShow'])->name('show');
                        Route::get('/create', [PageController::class, 'taskCreate'])->name('create');
                        Route::get('/edit/{id}', [PageController::class, 'taskEdit'])->name('edit');
                        Route::post('/', [PageController::class, 'taskStore'])->name('store');
                        Route::put('/{id}', [PageController::class, 'taskUpdate'])->name('update');
                        Route::delete('{id}', [PageController::class, 'taskDestroy'])->name('destroy');
                    });
            });
    });
