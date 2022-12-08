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


Route::prefix('admin')->namespace('Modules\User\Http\Controllers\Admin')->middleware('web','auth','admin-panel')->group(function() {

    Route::resource('/user', 'UserController');
    Route::get('/ajax/object/user', 'UserController@get_user_object')->name('get-user-object');
    Route::get('/inactive_users', 'UserController@inactive_users')->name('inactive_users');
    Route::get('/user_activation/{user}', 'UserController@user_activation')->name('user_activation');

    Route::get('/admin-search-user', 'UserController@index')->name('admin-search-user');


});





Route::prefix('admin/activity')->namespace('Modules\User\Http\Controllers\Admin')->middleware('web','auth','admin-panel')->group(function() {

    Route::get('/', 'ActivityController@index')->name('activity.index');
    Route::get('/create', 'ActivityController@create')->name('activity.create');
    Route::post('/store', 'ActivityController@store')->name('activity.store');
    Route::get('/edit/{activity}', 'ActivityController@edit')->name('activity.edit');
    Route::patch('/update/{activity}', 'ActivityController@update')->name('activity.update');
    Route::delete('/destroy/{activity}', 'ActivityController@destroy')->name('activity.destroy');

});
