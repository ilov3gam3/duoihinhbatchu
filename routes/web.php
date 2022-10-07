<?php

use App\Http\Controllers\Controller;
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
Route::get('/create', [Controller::class, 'index']);
Route::post('/create', [Controller::class, 'create']);
Route::post('/get_question', [Controller::class, 'get_question']);
Route::get('/get_question_id', [Controller::class, 'get_question_id']);

