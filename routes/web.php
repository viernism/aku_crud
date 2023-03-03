<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
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
    return view('home');
});

Route::get('/register', [CustomAuthController::class,'register']);
Route::get('/login', [CustomAuthController::class,'login']);
Route::post('/register-user',[CustomAuthController::class,'registerUser']);
Route::post('/login-user',[CustomAuthController::class,'loginUser']);
