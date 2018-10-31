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

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/user/{id}', 'UserController@index');

Route::get('/', 'HomeController@index');
Route::get('/detail/{id}', 'DetailController@index')->where('id', '[0-9]+');
Route::get('/catalog', 'CatalogController@index');
Route::post('/proccess', 'FileProccess@proccess');
Route::get('/comment/{id}', 'DetailController@addComment')->where('id', '[0-9]+');;
Route::get('/download/{id}', 'DownloadProccess@redirect')->where('id', '[0-9]+');;
Route::get('/search', 'CatalogController@search');

// Route::get('user/{id}', function ($id) {
//     return 'User '.$id;
// });
