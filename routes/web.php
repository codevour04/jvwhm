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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route::middleware('auth')->group(function () {
	Route::get('/people', function () {
		return view('people.index');
	});
	Route::get('/dashboard', function () {
		return view('dashboard.index');
	});
	Route::post('/people/search', 'PersonController@search');
	Route::resource('person', 'PersonController');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
