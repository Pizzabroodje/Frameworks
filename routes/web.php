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



Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/tournamenten', 'TournamentController@index')->name('tournaments.index')->middleware('verified');
Route::get('/tournament/{id}', 'TournamentController@show')->name('tournaments.show')->middleware('verified');
Route::post('/tournament/{id}', 'TournamentController@sync')->name('tournaments.sync')->middleware('verified');
