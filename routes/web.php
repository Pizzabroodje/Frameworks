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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes(['verify' => true]);

Route::get('/tournamenten', 'TournamentController@index')->name('tournaments.index');
Route::get('/tournament/{id}', 'TournamentController@show')->name('tournaments.show');
Route::post('/tournament/{id}', 'TournamentController@sync')->name('tournaments.sync');
