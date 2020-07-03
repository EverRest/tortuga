<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Auth routes
Route::group(['prefix' => 'auth', 'namespace' => 'Auth', 'name' => 'auth.', 'middleware' => 'api'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('register', 'AuthController@register')->name('register');
    Route::get('activate/{token}', 'AuthController@activate')->name('activate');

    Route::group(['middleware' => 'auth:api'], function() {
        Route::get('logout', 'AuthController@logout')->name('logout');
        Route::get('user', 'AuthController@user')->name('user');
    });
});

// PasswordReset routes
Route::group([ 'prefix' => 'password', 'namespace' => 'Password', 'name' => 'password.', 'middleware' => 'api'], function () {
    Route::post('create', 'PasswordResetController@create')->name('create');
    Route::get('find/{token}', 'PasswordResetController@find')->name('find');
    Route::post('reset', 'PasswordResetController@reset')->name('reset');
});

// Song Routes
Route::group([ 'prefix' => 'song', 'namespace' => 'Song', 'name' => 'song.', 'middleware' => 'auth:api'], function () {
    Route::post('/create', 'SongController@create')->name('create');
    Route::post('/upload', 'SongController@upload')->name('upload');
    Route::put('/update/{id}', 'SongController@update')->name('update');
    Route::delete('/delete/{id}', 'SongController@delete')->name('delete');
    Route::get('/{id}', 'SongController@item')->name('item');
    Route::get('/', 'SongController@index')->name('list');
});

// Playlist Routes
Route::group([ 'prefix' => 'playlist', 'namespace' => 'Playlist', 'name' => 'playlist.', 'middleware' => 'api'], function () {
    Route::post('/create', 'PlaylistController@create')->name('create');
    Route::put('/update/{id}', 'PlaylistController@update')->name('update');
    Route::delete('/delete/{id}', 'PlaylistController@delete')->name('delete');
    Route::get('/{id}', 'PlaylistController@item')->name('item');
    Route::get('/', 'PlaylistController@index')->name('list');
});
