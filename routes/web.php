<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomRegisterController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\CustomLogoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\UserProfileController;
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
//login-register
Route::middleware(['guest'])->group(function () {

    Route::get('/register', [CustomRegisterController::class,'register'])->name('register');

    Route::post('/register',[CustomRegisterController::class,'registerUser']);

    Route::get('/login', [CustomLoginController::class,'login'])->name('login');

    Route::post('/login',[CustomLoginController::class,'loginUser']);
});



Route::middleware(['auth', 'revalidate'])->group(function () {
    Route::get('/home', function () {
        return view('pages.home');
    });

    Route::get('/gedung', function() {
        return view('pages.table-gedung');
    });

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    });

    Route::get('/profile', [UserProfileController::class, 'index']);

    Route::post('/user-profile/update-profile-image', [UserProfileController::class, 'updateProfileImage'])->name('updateProfileImage');

    Route::put('/profile', [UserProfileController::class, 'EditProfile'])->name('edit.profile');

    Route::post('/logout', CustomLogoutController::class);
    //admin and things
    Route::get('/admin-panel', [UserController::class, 'index']);

    Route::get('users/{id}', [UserController::class, 'show'])->name('users.show');

    // Route to display the form for creating a new user
    Route::get('/admin-panel/create', [UserController::class, 'create'])->name('users.create');

    // Route to store the new user in the database
    Route::post('/admin-panel', [UserController::class, 'store'])->name('users.store');

    // Route to update the user in the database
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

    // Route to delete the user in the database
    Route::delete('/admin-panel/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::delete('/admin-panel/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/gedung', [GedungController::class, 'index']);

    Route::post('/gedung/store', [GedungController::class, 'store'])->name('gedung.store');
});

