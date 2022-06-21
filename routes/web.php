<?php

use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\PostsController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Website\CategoryController as WebsiteCategoryController;
use App\Http\Controllers\Website\IndexController;
use App\Http\Controllers\Website\PostController;
use Illuminate\Support\Facades\Route;

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



// website 


Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/categories/{category}', [WebsiteCategoryController::class, 'show'])->name('category');
Route::get('/post/{post}', [PostController::class, 'show'])->name('post');












// Dashboard


Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', 'checkLogin']], function () {

    Route::get('/', function () {
        return view('dashboard.layouts.layout');
    })->name('index');


    Route::get('/settings', [SettingController::class, 'index'])->name('settings');

    Route::post('/settings/update/{setting}', [SettingController::class, 'update'])->name('settings.update');


    Route::get('/users/all', [UserController::class, 'getUsersDatatable'])->name('users.all');
    Route::post('/users/delete', [UserController::class, 'delete'])->name('users.delete');


    Route::get('/category/all', [CategoryController::class, 'getCategoriesDatatable'])->name('category.all');
    Route::post('/category/delete', [CategoryController::class, 'delete'])->name('category.delete');



    Route::get('/posts/all', [PostsController::class, 'getPostsDatatable'])->name('posts.all');
    Route::post('/posts/delete', [PostsController::class, 'delete'])->name('posts.delete');


    Route::resources([
        'users' => UserController::class,
        'category' => CategoryController::class,
        'posts' => PostsController::class,
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
