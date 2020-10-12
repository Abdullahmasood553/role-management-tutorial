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





Route::get('login', 'LoginController@login')->name('login');
Route::post('user_login', 'LoginController@user_login');

Route::get('register', 'RegisterController@register');
Route::post('save_register', 'RegisterController@save_register')->name('save_user');


Route::get('/logout', 'LoginController@logout')->name('logout');  




Route::group(['middleware' => 'auth.user'], function () {
    
    Route::get('/', 'HomeController@dashboard')->name('dashboard');
});