<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomRegisterController;
use App\Http\Controllers\CustomLoginController;
use App\Http\Controllers\CustomLogoutController;
use App\Http\Controllers\UserController;
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

    // End Profile Routes

    // Logout Routes
    Route::post('/logout', CustomLogoutController::class);
});

Route::middleware(['auth','revalidate','role:Administrator'])->group(function () {
    //admin routes
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

    //role hell
    Route::get('/role-list',[RolePermissionController::class,'indexrole']);
});

Route::middleware(['auth','revalidate','role:AM|Administrator'])->name('gedung.')->group(function () {
    // table gedung routes
    Route::get('/tabel/gedung', [GedungController::class, 'index']);

    Route::post('/tabel/gedung/store', [GedungController::class, 'store'])->name('store');

    Route::put('/tabel/gedung/{gedungId}', [GedungController::class, 'update'])->name('update');

    Route::delete('/tabel/gedung/delete/{gedungId}', [GedungController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/gedung/exportexcel', [GedungController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/gedung/importexcel', [GedungController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('sekolah.')->group(function () {
    // table sekolah routes
    Route::get('/tabel/sekolah', [SekolahController::class, 'index']);

    Route::post('/tabel/sekolah/store', [SekolahController::class, 'store'])->name('store');

    Route::put('/tabel/sekolah/{sekolahId}', [SekolahController::class, 'update'])->name('update');

    Route::delete('/tabel/sekolah/delete/{sekolahId}', [SekolahController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/sekolah/search', [SekolahController::class, 'index'])->name('index');

    Route::get('/tabel/sekolah/exportexcel', [SekolahController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/sekolah/importexcel', [SekolahController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('health.')->group(function () {
    // table health routes
    Route::get('/tabel/health', [HealthController::class, 'index'])->name('index');

    Route::post('/tabel/health/store', [HealthController::class, 'store'])->name('store');

    Route::put('/tabel/health/{healthId}', [HealthController::class, 'update'])->name('update');

    Route::delete('/tabel/health/delete/{healthId}', [HealthController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/health/search', [HealthController::class, 'index'])->name('index');

    Route::get('/tabel/health/exportexcel', [HealthController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/health/importexcel', [HealthController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('kuliner.')->group(function () {
    // table kuliner routes
    Route::get('/tabel/kuliner', [KulinerController::class, 'index']);

    Route::post('/tabel/kuliner/store', [KulinerController::class, 'store'])->name('store');

    Route::put('/tabel/kuliner/{kulinerId}', [KulinerController::class, 'update'])->name('update');

    Route::delete('/tabel/kuliner/delete/{kulinerId}', [KulinerController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/kuliner/search', [KulinerController::class, 'index'])->name('index');

    Route::get('/tabel/kuliner/exportexcel', [KulinerController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/kuliner/importexcel', [KulinerController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('toko.')->group(function () {
    // table toko routes
    Route::get('/tabel/toko', [TokoController::class, 'index']);

    Route::post('/tabel/toko/store', [TokoController::class, 'store'])->name('store');

    Route::put('/tabel/toko/{tokoId}', [TokoController::class, 'update'])->name('update');

    Route::delete('/tabel/toko/delete/{tokoId}', [TokoController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/toko/search', [TokoController::class, 'index'])->name('index');

    Route::get('/tabel/toko/exportexcel', [TokoController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/toko/importexcel', [TokoController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('office.')->group(function () {
    // table office routes
    Route::get('/tabel/office', [OfficeController::class, 'index']);

    Route::post('/tabel/office/store', [OfficeController::class, 'store'])->name('store');

    Route::put('/tabel/office/{officeId}', [OfficeController::class, 'update'])->name('update');

    Route::delete('/tabel/office/delete/{officeId}', [OfficeController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/office/search', [OfficeController::class, 'index'])->name('index');

    Route::get('/tabel/office/exportexcel', [OfficeController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/office/importexcel', [OfficeController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('tourism.')->group(function () {
    // table tourism routes
    Route::get('/tabel/tourism', [TourismController::class, 'index']);

    Route::post('/tabel/tourism/store', [TourismController::class, 'store'])->name('store');

    Route::put('/tabel/tourism/{tourismId}', [TourismController::class, 'update'])->name('update');

    Route::delete('/tabel/tourism/delete/{tourismId}', [TourismController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/tourism/search', [TourismController::class, 'index'])->name('index');

    Route::get('/tabel/tourism/exportexcel', [TourismController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/tourism/importexcel', [TourismController::class,'importexcel'])->name('importexcel');
});

Route::middleware(['auth', 'revalidate','role:AM|Administrator'])->name('buscen.')->group(function () {
    // table business center routes
    Route::get('/tabel/buscen', [BuscenController::class, 'index']);

    Route::post('/tabel/buscen/store', [BuscenController::class, 'store'])->name('store');

    Route::put('/tabel/buscen/{buscenId}', [BuscenController::class, 'update'])->name('update');

    Route::delete('/tabel/buscen/delete/{buscenId}', [BuscenController::class, 'destroy'])->name('destroy');

    Route::get('/tabel/buscen/search', [BuscenController::class, 'index'])->name('index');

    Route::get('/tabel/buscen/exportexcel', [BuscenController::class,'exportexcel'])->name('exportexcel');

    Route::post('/tabel/buscen/importexcel', [BuscenController::class,'importexcel'])->name('importexcel');
});

Route::redirect('/', '/profile');
