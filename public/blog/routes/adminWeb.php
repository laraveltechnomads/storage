
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCatController;

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    
    Route::get('change-password', [ChangePasswordController::class, 'index'])->name('change.password.page');
    Route::post('change-password', [ChangePasswordController::class, 'store'])->name('admin.change.password');
    Route::get('logout-user', [LoginController::class, 'logOut'])->name('logout');

    Route::get('dashboard', [AdminController::class,'index'])->name('admin.dashboard');
    
    Route::prefix('contact')->group(function () {
        Route::get('/', [AdminController::class,'contactIndex'])->name('admin.contact.us.index');
        Route::get('update_contact/{id}', [AdminController::class,'updateContact'])->name('admin.update_contact.index');
    });
    //category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category.index');
        Route::get('create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('store', [CategoryController::class, 'store'])->name('admin.category.store');
        Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
        Route::post('update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::get('view/{id}', [CategoryController::class, 'show'])->name('admin.category.view');
    });

    //sub category
    Route::prefix('sub-category')->group(function () {
        Route::get('/', [SubCatController::class, 'index'])->name('admin.sub_category.index');
        Route::get('create', [SubCatController::class, 'create'])->name('admin.sub_category.create');
        Route::post('store', [SubCatController::class, 'store'])->name('admin.sub_category.store');
        Route::get('destroy/{id}', [SubCatController::class, 'destroy'])->name('admin.sub_category.destroy');
        Route::get('edit/{id}', [SubCatController::class, 'edit'])->name('admin.sub_category.edit');
        Route::post('update/{id}', [SubCatController::class, 'update'])->name('admin.sub_category.update');
        Route::get('view/{id}', [SubCatController::class, 'show'])->name('admin.sub_category.view');
    });

    Route::group(['as'=>'admin.'], function () {
        
        Route::resource('products', ProductController::class);
        Route::get('products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
        //product
        // Route::prefix('product')->group(function () {
        //     Route::get('/', [CategoryController::class, 'index'])->name('product.index');
        //     Route::get('create', [CategoryController::class, 'create'])->name('product.create');
        //     Route::post('store', [CategoryController::class, 'store'])->name('product.store');
        //     Route::get('destroy/{id}', [CategoryController::class, 'destroy'])->name('product.destroy');
        //     Route::get('edit/{id}', [CategoryController::class, 'edit'])->name('product.edit');
        //     Route::post('update/{id}', [CategoryController::class, 'update'])->name('product.update');
        //     Route::get('view/{id}', [CategoryController::class, 'show'])->name('product.view');
        // });
    });

    /* newsletter*/
    Route::prefix('newsletter')->group(function () {
        Route::get('/', [NewsletterController::class, 'index'])->name('admin.newsletter.index');
        Route::get('list', [NewsletterController::class, 'list'])->name('admin.newsletter.list');
        Route::get('destroy/{id}', [NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');
    });
});