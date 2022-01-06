<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});
Route::get('/feedback', function() {
    return 'You\'ve been clicked, punk.';
});

Route::get('top-headlines', function() {
    return \App\Services\NewsService::make()->headlines();
});

Route::post('/contact', [\App\Http\Controllers\SupportController::class, 'store']);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
