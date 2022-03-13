<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/php-artisan', function () {
    Artisan::call('migrate:fresh --seed');
    // Artisan::call('storage:link');
    return redirect('/');
});

Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
    return redirect('/');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/book/{bookId}', 'BookController@book');

Route::get('/books', 'BookController@index');
Route::get('/books/search', 'BookController@search');
Route::get('/books/{categoryId}', 'BookController@category');

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', 'LoginController@index')->name('login');
    Route::get('/register', 'RegisterController@index');

    Route::post('/register', 'RegisterController@register');
    Route::post('/login', 'LoginController@login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/chat/{chatPartner}', 'ChatController@index');
    Route::get('/ongoing', 'TransactionController@index');
    Route::get('/history', 'TransactionController@history');
    Route::get('/books/user/{userId}', 'BookController@user');
    // Route::get('/upload', 'BookContrdoller@user');

    

    Route::post('/topup/{amount}', 'MainController@topup');
    Route::post('/withdraw', 'MainController@withdraw');

    Route::post('/rent/{bookId}', 'TransactionController@rent');
    Route::post('/transaction/reject', 'TransactionController@deny');
    Route::post('/transaction/accept', 'TransactionController@accept');
    Route::post('/transaction/cancel', 'TransactionController@cancel');

    Route::post('/delete/{id}', 'BookController@delete');
    
    
    Route::post('/chat/send', 'ChatController@send');
    Route::post('/logout', 'LoginController@logout');

    Route::post('/review/{transactionId}', 'TransactionController@review');
    Route::post('/report/{transactionId}', 'TransactionController@report');

    Route::get('/admin', 'AdminController@index');
    Route::post('/ban', 'AdminController@ban');
});


