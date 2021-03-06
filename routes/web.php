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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/SchoolStudent/post','StudentController@formPost');
Route::post('/OutsideStudent/post','OnlineStudentController@formPost');
Route::get('/SchoolStudent/export','StudentController@exportStudent');
Route::get('/OutsideStudent/export','OnlineStudentController@exportStudent');
