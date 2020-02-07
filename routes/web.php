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


Auth::routes();

Route::get('lang/{locale}', 'LanguageController@setLocale')->name('lang');

Route::redirect('/','/login');

Route::get('/home', 'HomeController@index')->name('dashboard');
Route::post('/dashboard/getbalance', 'DashboardController@getBalance')->name('dashboard.getbalance');


//Route::get('/', function () {
    //return view('welcome');
//});
//Route::get('/', 'WelcomeController@index')->name('home');
//Route::post('/', 'WelcomeController@index');


