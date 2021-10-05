<?php

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

Route::get('/',[App\Http\Controllers\BlogController::class, 'index'])->name('blog.home');

Auth::routes();

Route::get('register/{role}/{view}',[App\Http\Controllers\Auth\RegisterController::class,'showRegistrationFormWithRole'])->name('registration');

Route::get('/admin/home',[App\Http\Controllers\UserController::class, 'index'])->name('admin.home');

Route::middleware(['auth'])->group(function () {
    Route::get("myblogs",[App\Http\Controllers\BlogController::class,'myBlogs'])->name('blogs.myblogs');
    Route::get("blogs/{blog}/delete",[App\Http\Controllers\BlogController::class, 'delete'])->name('blogs.delete');
    Route::resource('comments','App\Http\Controllers\CommentController');
});

Route::resource('blogs','App\Http\Controllers\BlogController');

Route::get("blogs/search/{category}",[App\Http\Controllers\BlogController::class,'search'])->name('blogs.search');

Route::middleware(['admin.auth'])->group(function () {
    Route::resource('users','App\Http\Controllers\UserController');
    Route::get("users/{user}/delete",[App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
});
