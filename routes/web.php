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

//prefixメソッドはグループ内の各ルートに対して、指定されたURIのプレフィックスを指定するために使用。今回の場合は、グループ内の全ルートのURIの頭にtaskがつく。
//認証の場合だけ表示するために'middleware' => 'auth'と書く。
Route::group(['prefix' => 'task', 'middleware' => 'auth'], function () {
    Route::get('index', 'TaskController@index')->name('task.index');
    Route::get('create', 'TaskController@create')->name('task.create');
    Route::post('store', 'TaskController@store')->name('task.store');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
