<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomRegisterController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\CustomLogoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GedungController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\KulinerController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\BuscenController;
use App\Http\Controllers\TourismController;
use App\Http\Controllers\UserProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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

    // Profile Routes
    Route::get('/profile', [UserProfileController::class, 'index']);

    Route::post('/user-profile/update-profile-image', [UserProfileController::class, 'updateProfileImage'])->name('updateProfileImage');

    Route::put('/profile', [UserProfileController::class, 'EditProfile'])->name('edit.profile');

    // Logout Routes
    Route::post('/logout', CustomLogoutController::class);
});

Route::middleware(['auth','revalidate','role:Administrator'])->prefix('/admin')->group(function () {
    Route::controller(AdminController::class)->group(function () {
        //admin routes
        Route::get('/users-list', 'index');

        Route::get('/users-list/{id}', 'show')->name('users.show');

        // Route to display the form for creating a new user
        Route::get('/users-list/create', 'create')->name('users.create');

        // Route to store the new user in the database
        Route::post('/users-list/store', 'store')->name('users.store');

        // Route to update the user in the database

        Route::match(['get', 'post'], '/users-list/update/{id}', 'update')->name('admin.users.update');

        // Route to delete the user in the database
        Route::delete('/users-list/delete/{user}', 'destroy')->name('admin.users.destroy');

        Route::delete('/users-list/delete/{id}', 'destroy')->name('admin.users.destroy');

        Route::delete('/user-list/deleteSeleted','deleteSelected');
    });
});

Route::prefix('/tabel')->group(function(){
    Route::controller(GedungController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('gedung')->name('gedung.')->group(function () {
        // table gedung routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{gedungId}', 'update')->name('update');
    
        Route::delete('/delete/{gedungId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(SekolahController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('sekolah')->name('sekolah.')->group(function () {
        // table sekolah routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{sekolahId}', 'update')->name('update');
    
        Route::delete('/delete/{sekolahId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addlevel', 'addLevel')->name('addlevel');
    });
    
    Route::controller(HealthController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('health')->name('health.')->group(function () {
        // table health routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{healthId}', 'update')->name('update');
    
        Route::delete('/delete/{healthId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(KulinerController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('kuliner')->name('kuliner.')->group(function () {
        // table kuliner routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{kulinerId}', 'update')->name('update');
    
        Route::delete('/delete/{kulinerId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/search', 'index')->name('index');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(TokoController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('toko')->name('toko.')->group(function () {
        // table toko routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{tokoId}', 'update')->name('update');
    
        Route::delete('/delete/{tokoId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(OfficeController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('office')->name('office.')->group(function () {
        // table office routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{officeId}', 'update')->name('update');
    
        Route::delete('/delete/{officeId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(TourismController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('tourism')->name('tourism.')->group(function () {
        // table tourism routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{tourismId}', 'update')->name('update');
    
        Route::delete('/delete/{tourismId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
    
    Route::controller(BuscenController::class)->middleware(['auth','revalidate','can:CRUD'])->prefix('buscen')->name('buscen.')->group(function () {
        // table buscen routes
        Route::get('/', 'index');
    
        Route::post('/store', 'store')->name('store');
    
        Route::match(['get', 'post'], '/edit/{buscenId}', 'update')->name('update');
    
        Route::delete('/delete/{buscenId}', 'destroy')->name('destroy');
    
        Route::delete('/deleteSelected', 'deleteSelected');
    
        Route::get('/excel/export', 'exportexcel')->name('exportexcel');
    
        Route::post('/excel/import', 'importexcel')->name('importexcel');
    
        Route::post('/addkategori', 'addKategori')->name('addkategori');
    });
});

Route::redirect('/', '/profile');