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

//Route::get('test', function () {
//    var_dump(Config::get('admin.upload.host'));
//});

Route::post('upload/{type?}', 'ImageController@upload');

Route::resource('test', 'TestController');

Route::get('goods/{id?}', 'GoodsController@index');
