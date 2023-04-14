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
use App\Http\Controllers\RolePermissionController;
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
    Route::get('/home', function () {
        return view('pages.home');
    });

    Route::get('/dashboard', function () {
        return view('pages.dashboard');
    });

    // Profile Routes
    Route::get('/profile', [UserProfileController::class, 'index']);

    Route::post('/user-profile/update-profile-image', [UserProfileController::class, 'updateProfileImage'])->name('updateProfileImage');

    Route::put('/profile', [UserProfileController::class, 'EditProfile'])->name('edit.profile');

    // Logout Routes
    Route::post('/logout', CustomLogoutController::class);
});

Route::middleware(['auth','revalidate','role:Administrator'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        //admin routes
        Route::get('/admin/users-list', 'index');

        Route::get('/admin/users-list/{id}', 'show')->name('users.show');

        // Route to display the form for creating a new user
        Route::get('/admin/users-list/create', 'create')->name('users.create');

        // Route to store the new user in the database
        Route::post('/admin/users-list/store', 'store')->name('users.store');

        // Route to update the user in the database

        Route::match(['get', 'post'], '/admin/users-list/update/{id}', 'update')->name('admin.users.update');

        // Route to delete the user in the database
        Route::delete('/admin/users-list/delete/{user}', 'destroy')->name('admin.users.destroy');

        Route::delete('/admin/users-list/delete/{id}', 'destroy')->name('admin.users.destroy');
    });

    Route::controller(RolePermissionController::class)->group(function(){
        //role hell
        Route::get('/admin/rolepermission','index')->name('role.index');

        Route::post('/admin/rolepermission/store','store')->name('role.store');

        Route::match(['get', 'post'], '/admin/rolepermission/edit/{roleId}', 'update')->name('role.update');

        Route::delete('/admin/rolepermission/delete/{roleId}', 'destroy')->name('role.destroy');

        Route::delete('/admin/rolepermission/deleteSelected', 'deleteSelected');

        //permission hell

        Route::post('/admin/permission/store','storeP')->name('permission.store');

        Route::match(['get', 'post'], '/admin/permission/edit/{permissionId}', 'updateP')->name('permission.update');

        Route::delete('/admin/permission/delete/{permissionId}', 'destroyP')->name('permission.destroy');

        Route::delete('/admin/permission/deleteSelected', 'deleteSelectedP');
    });


});

Route::controller(GedungController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('gedung.')->group(function () {
    // table gedung routes
    Route::get('/tabel/gedung', 'index');

    Route::post('/tabel/gedung/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/gedung/edit/{gedungId}', 'update')->name('update');

    Route::delete('/tabel/gedung/delete/{gedungId}', 'destroy')->name('destroy');

    Route::delete('/tabel/gedung/deleteSelected', 'deleteSelected');

    Route::get('/tabel/gedung/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/gedung/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(SekolahController::class)->middleware(['auth', 'revalidate','role:AM|Administrator'])->name('sekolah.')->group(function () {
    // table sekolah routes
    Route::get('/tabel/sekolah', 'index');

    Route::post('/tabel/sekolah/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/sekolah/edit/{sekolahId}', 'update')->name('update');

    Route::delete('/tabel/sekolah/delete/{sekolahId}', 'destroy')->name('destroy');

    Route::delete('/tabel/sekolah/deleteSelected', 'deleteSelected');

    Route::get('/tabel/sekolah/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/sekolah/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(HealthController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('health.')->group(function () {
    // table health routes
    Route::get('/tabel/health', 'index');

    Route::post('/tabel/health/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/health/edit/{healthId}', 'update')->name('update');

    Route::delete('/tabel/health/delete/{healthId}', 'destroy')->name('destroy');

    Route::delete('/tabel/health/deleteSelected', 'deleteSelected');

    Route::get('/tabel/health/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/health/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(KulinerController::class)->middleware(['auth', 'revalidate','role:AM|Administrator'])->name('kuliner.')->group(function () {
    // table kuliner routes
    Route::get('/tabel/kuliner', 'index');

    Route::post('/tabel/kuliner/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/kuliner/edit/{kulinerId}', 'update')->name('update');

    Route::delete('/tabel/kuliner/delete/{kulinerId}', 'destroy')->name('destroy');

    Route::delete('/tabel/kuliner/deleteSelected', 'deleteSelected');

    Route::get('/tabel/kuliner/search', 'index')->name('index');

    Route::get('/tabel/kuliner/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/kuliner/importexcel', 'importexcel')->name('importexcel');

    Route::post('/tabel/kuliner/addkategori', 'addKategori')->name('addkategori');
});

Route::controller(TokoController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('toko.')->group(function () {
    // table toko routes
    Route::get('/tabel/toko', 'index');

    Route::post('/tabel/toko/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/toko/edit/{tokoId}', 'update')->name('update');

    Route::delete('/tabel/toko/delete/{tokoId}', 'destroy')->name('destroy');

    Route::delete('/tabel/toko/deleteSelected', 'deleteSelected');

    Route::get('/tabel/toko/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/toko/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(OfficeController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('office.')->group(function () {
    // table office routes
    Route::get('/tabel/office', 'index');

    Route::post('/tabel/office/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/office/edit/{officeId}', 'update')->name('update');

    Route::delete('/tabel/office/delete/{officeId}', 'destroy')->name('destroy');

    Route::delete('/tabel/office/deleteSelected', 'deleteSelected');

    Route::get('/tabel/office/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/office/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(TourismController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('tourism.')->group(function () {
    // table tourism routes
    Route::get('/tabel/tourism', 'index');

    Route::post('/tabel/tourism/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/tourism/edit/{tourismId}', 'update')->name('update');

    Route::delete('/tabel/tourism/delete/{tourismId}', 'destroy')->name('destroy');

    Route::delete('/tabel/tourism/deleteSelected', 'deleteSelected');

    Route::get('/tabel/tourism/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/tourism/importexcel', 'importexcel')->name('importexcel');
});

Route::controller(BuscenController::class)->middleware(['auth','revalidate','role:AM|Administrator'])->name('buscen.')->group(function () {
    // table buscen routes
    Route::get('/tabel/buscen', 'index');

    Route::post('/tabel/buscen/store', 'store')->name('store');

    Route::match(['get', 'post'], '/tabel/buscen/edit/{buscenId}', 'update')->name('update');

    Route::delete('/tabel/buscen/delete/{buscenId}', 'destroy')->name('destroy');

    Route::delete('/tabel/buscen/deleteSelected', 'deleteSelected');

    Route::get('/tabel/buscen/exportexcel', 'exportexcel')->name('exportexcel');

    Route::post('/tabel/buscen/importexcel', 'importexcel')->name('importexcel');
});

Route::redirect('/', '/profile');

