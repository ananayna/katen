<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::controller(ProfileController::class)->group(function(){
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/update', 'update')->name('update');
        Route::put('/change.password', 'changePassword')->name('changePassword');
    });

    Route::controller(CategoryController::class)->name('category.')->prefix('/backend/categories')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/change-status', 'change_status')->name('change_status');
    });

    Route::controller(SubCategoryController::class)->name('subcategory.')->prefix('/backend/subcategories')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/get-subcategory', 'getSubcategory')->name('getSubcategory');
        Route::get('/change-status', 'change_status')->name('change_status');
    });

    Route::controller(PostController::class)->name('post.')->prefix('/backend/post')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/create', 'create')->name('create');
        Route::get('/view/{id}', 'view')->name('view');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::delete('/delete/{id}', 'delete')->name('delete');
        Route::get('/change-status', 'change_status')->name('change_status');
        Route::get('/change-featured', 'change_featured')->name('change_featured');
    });
});

