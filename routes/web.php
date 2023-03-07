<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\UserController;
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

Route::get('/home', function () {
    return view('pages.home');
});

Route::get('/user-profile', function() {
    return view('pages.user-profile');
});

Route::get('/gedung', function() {
    return view('pages.table-gedung');
});

Route::get('/dashboard', function () {
    return view('pages.dashboard');
});

Route::get('/register', [CustomAuthController::class,'register']);

Route::get('/login', [CustomAuthController::class,'login']);

Route::post('/register-user',[CustomAuthController::class,'registerUser']);

Route::post('/login-user',[CustomAuthController::class,'loginUser']);

Route::get('/admin-panel', [UserController::class, 'index']);

Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');

// Route to display the form for creating a new user
Route::get('/admin-panel/create', [UserController::class, 'create'])->name('users.create');

// Route to store the new user in the database
Route::post('/admin-panel', [UserController::class, 'store'])->name('users.store');

// Route to update the user in the database
Route::put('/admin-panel/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

// Route to update the user in the database
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

// Route to delete the user in the database
Route::delete('/admin-panel/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');






