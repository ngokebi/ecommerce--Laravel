<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\AdminProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductsController;
use App\Http\Controllers\Frontend\IndexController;
use App\Models\Brand;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//
//     return view('welcome');
// });

Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    $id = Auth::user()->id;
    $user = User::find($id);
    return view('dashboard', compact('user'));
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

// All Category Route

Route::prefix('category')->group(function(){

    Route::get('/all', [CategoryController::class, 'Category'])->name('all.category');
    Route::get('/add', [CategoryController::class, 'AddCategory'])->name('add.category');
    Route::post('/store', [CategoryController::class, 'StoreCategory'])->name('store.category');
    Route::get('/edit/{id}', [CategoryController::class, 'EditCategory'])->name('edit.category');
    Route::get('/delete/{id}', [CategoryController::class, 'DeleteCategory'])->name('delete.category');
    Route::post('/update', [CategoryController::class, 'UpdateCategory'])->name('update.category');

});

Route::prefix('subcategory')->group(function(){

    Route::get('/all', [SubCategoryController::class, 'SubCategory'])->name('all.subcategory');
    Route::get('/add', [SubCategoryController::class, 'AddSubCategory'])->name('add.subcategory');
    Route::post('/store', [SubCategoryController::class, 'StoreSubCategory'])->name('store.subcategory');
    Route::get('/edit/{id}', [SubCategoryController::class, 'EditSubCategory'])->name('edit.subcategory');
    Route::get('/delete/{id}', [SubCategoryController::class, 'DeleteSubCategory'])->name('delete.subcategory');
    Route::post('/update', [SubCategoryController::class, 'UpdateSubCategory'])->name('update.subcategory');

});

Route::prefix('sub_subcategory')->group(function(){

    Route::get('/all', [SubCategoryController::class, 'Sub_SubCategory'])->name('all.sub_subcategory');
    Route::get('/add', [SubCategoryController::class, 'AddSub_SubCategory'])->name('add.sub_subcategory');
    Route::post('/store', [SubCategoryController::class, 'StoreSub_SubCategory'])->name('store.sub_subcategory');
    Route::get('/edit/{id}', [SubCategoryController::class, 'EditSub_SubCategory'])->name('edit.sub_subcategory');
    Route::get('/delete/{id}', [SubCategoryController::class, 'DeleteSub_SubCategory'])->name('delete.sub_subcategory');
    Route::post('/update', [SubCategoryController::class, 'UpdateSub_SubCategory'])->name('update.sub_subcategory');
    Route::get('/subcategory/ajax/{category_id}', [SubCategoryController::class, 'Get_SubCategory']);
    Route::get('/subsubcategory/ajax/{subcategory_id}', [SubCategoryController::class, 'Get_SubSubCategory']);

});

Route::prefix('products')->group(function(){

    Route::get('/all', [ProductsController::class, 'Products'])->name('manage.products');
    Route::get('/add', [ProductsController::class, 'AddProducts'])->name('add.products');
    Route::post('/store', [ProductsController::class, 'StoreProducts'])->name('store.products');
    Route::get('/edit/{id}', [ProductsController::class, 'EditProducts'])->name('edit.products');
    Route::get('/delete/{id}', [ProductsController::class, 'DeleteProducts'])->name('delete.products');
    Route::post('/update', [ProductsController::class, 'UpdateProducts'])->name('update.products');

});
