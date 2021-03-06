<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RunnerController;

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

// POST
Route::post('/runner', 'RunnerController@create');
Route::post('/race', 'RaceController@create');
Route::post('/race-runner', 'RaceRunnerController@create');
Route::post('/race-runner-results', 'RaceRunnerController@setResults');

Route::group(['prefix' => 'classification'], function () {
    Route::get('/by-age', 'ClassificationController@byAge');
    Route::get('/overall', 'ClassificationController@overall');
});
