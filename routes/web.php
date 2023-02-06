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

Route::get('/', 'ProductController@index')->name('index');
Route::post('search', 'ProductController@search')->name('search');
Route::get('new', 'ProductController@new')->name('new');
Route::post('new', 'ProductController@regist')->name('regist');
Route::get('destroy/{id}', 'ProductController@destroy')->name('destroy');
Route::get('show/{id}', 'ProductController@show')->name('show');
Route::get('edit/{id}', 'ProductController@edit')->name('edit');
Route::post('edit/{id}', 'ProductController@update')->name('update');

Auth::routes();
