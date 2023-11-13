<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;

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

Inertia::share('user', fn (Request $request) => $request->user()
    ? $request->user()
    : null
);


Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', 'index')->name('login');
        Route::post('/attempt', 'login');
    });

    Route::post('/logout', 'logout')->middleware('auth');
});

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/containers', function () {
            return Inertia::render('Dashboard/Containers');
        })->name('containers');

        Route::get('/widgets', function () {
            return Inertia::render('Dashboard/Widgets');
        })->name('widgets');

    });

    Route::controller(ProductController::class)->prefix('product')->middleware('auth')->name('product.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');

        Route::post('/verify/details', 'verifyDetails');
        Route::post('/{id}/verify/details', 'verifyDetails');

        Route::get('/verify/details', 'redirectOnCreateRefresh');
        Route::get('/{id}/verify/details', 'redirectOnRefresh');

        Route::post('/verify/images', 'verifyImagesEdit');
        Route::post('/{id}/verify/images', 'verifyDetailsEdit');

        Route::get('/verify/images', 'redirectOnCreateRefresh');
        Route::get('/{id}/verify/images', 'redirectOnRefresh');
        
        Route::get('/data', 'data')->name('data');
    });
});
