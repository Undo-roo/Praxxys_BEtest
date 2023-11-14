<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminRoute;
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

Route::get('/', function(){
    // dd(request()->user());
    return Inertia::render('Landing');
});

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::post('/attempt', 'login');
    });

    Route::post('/logout', 'logout')->middleware('auth');
});

//  
Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'index')->name('login');
        Route::get('/register', 'register')->name('register');
        Route::post('/register', 'create')->name('customer.create');
        Route::post('/attempt', 'login');
    });

    Route::post('/logout', 'logout')->middleware('auth');
});

/**
 * Customer User Routes
 */
Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        //dashboard.<route name>
        Route::get('/', function () {
            return Inertia::render('Customer/Dashboard/Profile');
        })->name('containers');
    });

    // ->middleware('auth')
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/{product}', 'show')->name('show');
    });

    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::post('/add/{product}', 'add')->name('add');
        Route::delete('/delete/{cart}', 'destroy')->name('destroy');
    });
});


/**
 * Admin User Routes
 */
Route::middleware(['auth', AdminRoute::class])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // admin.dashboard.<route name>
        Route::get('/containers', function () {
            return Inertia::render('Admin/Dashboard/Containers');
        })->name('containers');

        Route::get('/widgets', function () {
            return Inertia::render('Admin/Dashboard/Widgets');
        })->name('widgets');

    });

    // ->middleware('auth')
    Route::controller(AdminProductController::class)->prefix('product')->name('product.')->group(function () {
    
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