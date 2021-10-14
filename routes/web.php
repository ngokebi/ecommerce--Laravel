<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Frontend\IndexController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    $brands = DB::table('brands')->get();
    return view('dashboard', compact('user', 'brands'));
})->name('dashboard');


// Admin all Route

Route::group(['prefix' => 'admin', 'middleware' =>['admin:admin']], function() {
    Route::get('/login', [AdminController::class, 'LoginForm']);
    Route::post('/login', [AdminController::class, 'store'])->name('admin.login');
});

Route::middleware(['auth:sanctum,admin', 'verified'])->get('/admin/dashboard', function () {
    return view('admin.index');
})->name('admin.dashboard');

Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');

Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');

Route::get('/admin/profile/edit', [AdminProfileController::class, 'AdminProfileEdit'])->name('admin.profile.edit');

Route::post('/admin/profile/store', [AdminProfileController::class, 'AdminProfileStore'])->name('admin.profile.store');

Route::get('/admin/password', [AdminProfileController::class, 'AdminPassword'])->name('admin.password');

Route::post('/admin/password/update', [AdminProfileController::class, 'UpdatePassword'])->name('admin.profile.changepassword');

// User All Route

Route::get('/', [IndexController::class, 'index'])->name('home');

Route::get('/user/logout', [IndexController::class, 'UserLogout'])->name('user.logout');

Route::get('/user/profile', [IndexController::class, 'UserProfile'])->name('user.profile');

Route::post('/user/profile/update', [IndexController::class, 'UpdateProfile'])->name('user.profileupdate');

Route::post('/user/profile', [IndexController::class, 'UpdatePassword'])->name('user.password');

Route::post('/user/profile/picture', [IndexController::class, 'UpdatePicture'])->name('user.picture');


//  All Brands Route

Route::prefix('brand')->group(function(){

    Route::get('/all', [BrandController::class, 'Brands'])->name('all.brand');
    Route::get('/add', [BrandController::class, 'AddBrands'])->name('add.brand');
    Route::post('/store', [BrandController::class, 'StoreBrands'])->name('store.brand');
    Route::get('/edit/{id}', [BrandController::class, 'EditBrands'])->name('edit.brand');
    Route::get('/delete/{id}', [BrandController::class, 'DeleteBrands'])->name('delete.brand');
    Route::post('/update', [BrandController::class, 'UpdateBrands'])->name('update.brand');
});
