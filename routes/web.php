<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\DomainController;
use Illuminate\Support\Arr;
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

Route::domain('{subdomain}.assesment.test')->group(function(){

    $subdomain = Arr::first(explode('.', request()->getHost()));
    Route::middleware('checkdomain:'.$subdomain)->group(function() use($subdomain){
        Route::view('/', 'welcome');
        Route::middleware('guest')->group(function(){
            Route::get('/login', [AdminAuthController::class, 'loginAdmin'])->name('admin.login');
            Route::post('/login', [AdminAuthController::class, 'login'])->name('post.admin.login');
        });
        Route::middleware(['auth:admin','admindomains:'.$subdomain])->group(function(){
            Route::get('/dashboard', [AdminAuthController::class, 'dashboard']);
            Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
            Route::resource('users', UserController::class);
        });
        Route::middleware(['auth', 'userdomains:'.$subdomain])->group(function(){
            Route::get('/user/dashboard', [AdminAuthController::class, 'userDashboard'])->name('users.dashboard');
            Route::get('/user/logout', [AdminAuthController::class, 'userLogout'])->name('user.logout');
        });
    });
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [AuthController::class, 'loginSuperAdmin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post.superadmin.login');

Route::middleware('auth:superadmin')->group(function(){
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::resource('admins', AdminController::class);
    Route::resource('domains', DomainController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
