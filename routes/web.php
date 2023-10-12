<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SuperAdmin\AdminController;
use App\Http\Controllers\SuperAdmin\DomainController;
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
Route::get('/login', [AuthController::class, 'loginSuperAdmin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('post.superadmin.login');

Route::middleware('auth:superadmin')->group(function(){
    Route::get('/dashboard', [AuthController::class, 'dashboard']);
    Route::resource('admins', AdminController::class);
    Route::resource('domains', DomainController::class);
});
