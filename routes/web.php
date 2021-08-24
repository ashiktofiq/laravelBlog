<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingController;
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

// home
Route::get('/', [HomeController::class, 'index']);
Route::get('/detail/{slug}/{id}', [HomeController::class, 'detail']);
Route::post('/save-comment/{slug}/{id}',[HomeController::class,'save_comment']);
Route::get('save-post-form',[HomeController::class,'save_post_form']);
Route::post('save-post-form',[HomeController::class,'save_post_data']);
Route::get('/category/{slug}/{id}',[HomeController::class,'category']);
Route::get('/all-categories',[HomeController::class,'all_category']);
Route::get('manage-posts',[HomeController::class,'manage_posts']);
Route::get('manage-posts/delete/{id}',[HomeController::class,'delete_manage_post']);
Route::get('manage-post-edit/{id}',[HomeController::class,'manage_post_edit']);
Route::post('manage-post-edit/{id}',[HomeController::class,'manage_post_update']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// admin
Route::get('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/login', [AdminController::class, 'submit_login']);
Route::get('/admin/logout', [AdminController::class, 'logout']);
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
// admin comment
Route::get('admin/comment',[AdminController::class,'comments']);
Route::get('admin/comment/delete/{id}',[AdminController::class,'delete_comment']);
// admin user
Route::get('admin/user',[AdminController::class,'users']);
Route::get('admin/user/delete/{id}',[AdminController::class,'delete_user']);
// admin category
Route::resource('admin/category',CategoryController::class);
Route::get('/admin/category/{id}/delete', [CategoryController::class, 'destroy']);
// admin post
Route::resource('admin/post',PostController::class);
Route::get('/admin/post/{id}/delete', [PostController::class, 'destroy']);
// admin setting
Route::get('/admin/setting', [SettingController::class, 'index']);
Route::post('/admin/setting', [SettingController::class, 'save_setting']);


