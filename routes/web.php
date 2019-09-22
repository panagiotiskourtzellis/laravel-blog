<?php

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
//     return view('welcome');
// });

// Route::get('/about', function () {
//     return view('pages.about');
// });

// Route::get('/users/{id}/{name}', function ($id, $name) {
//     return 'This is user '.$name.' with id '.$id;
// });

// Main page
Route::get('/', 'PagesController@index');
// About page
Route::get('/about', 'PagesController@about');
// Services page
Route::get('/services', 'PagesController@services');
// All post routes
Route::resource('posts', 'PostsController');
// All comment routes
Route::resource('comments', 'CommentsController');
// Add comment route with parameter
Route::post('/comment/store', 'CommentsController@store')->name('comment.add');
// Reply comment route with parameter
Route::post('/reply/store', 'CommentsController@replyStore')->name('reply.add');
// Dashboard page
Route::get('/dashboard', 'DashboardController@index');
// Admin route check
Route::get('/admin', 'AdminController@admin')->middleware('is_admin')->name('admin');

Auth::routes();