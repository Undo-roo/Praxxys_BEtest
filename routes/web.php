<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use App\Http\Middleware\AdminRoute;
use App\Http\Middleware\CheckoutGuard;

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
        })->name('profile');
    });

    // ->middleware('auth')
    Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/{product}', 'show')->name('show');
    });

    Route::controller(CartController::class)->prefix('cart')->name('cart.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/checkout', 'checkout')->middleware(CheckoutGuard::class)->name('checkout');
        Route::post('/add/{product}', 'add')->name('add');
        Route::delete('/delete/{item}', 'destroy')->name('destroy');
        Route::patch('/edit/{item}', 'edit')->name('edit');
        Route::get('/success', 'success')->middleware(CheckoutGuard::class)->name('success');
        Route::get('/cancel', 'cancel')->middleware(CheckoutGuard::class)->name('cancel');

        Route::post('/payment', 'payment')->middleware(CheckoutGuard::class)->name('payment');
        Route::get('/payment', 'payment')->middleware(CheckoutGuard::class)->name('payment');
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
    // admin/product/{name}
    Route::controller(AdminProductController::class)->prefix('product')->name('product.')->group(function () {
    
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');

        Route::post('/verify/details', 'verifyDetails');
        Route::post('/verify/images', 'verifyImages');
        
        Route::get('/data', 'data')->name('data');
        Route::delete('/remove/{product}', 'remove')->name('remove');
    });
});


Route::get('/test', function(){
    // dd(request()->user());
    return Inertia::render('Test');
});