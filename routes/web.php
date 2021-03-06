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
    Route::get('show/{task}', 'TaskController@show')->name('task.show');   //依存性の注入
    Route::get('edit/{task}', 'TaskController@edit')->name('task.edit');   //依存性の注入
    Route::POST('update/{task}', 'TaskController@update')->name('task.update');   //依存性の注入
    Route::post('destroy/{task}', 'TaskController@destroy')->name('task.destroy'); //依存性の注入
});

//prefixメソッドはグループ内の各ルートに対して、指定されたURIのプレフィックスを指定するために使用。今回の場合は、グループ内の全ルートのURIの頭にcommentがつく。
//認証の場合だけ表示するために'middleware' => 'auth'と書く。
Route::group(['prefix' => 'comment', 'middleware' => 'auth'], function () {
    Route::post('store/{task}', 'CommentController@store')->name('comment.store');
});

Auth::routes();

Route::get('/home', 'TaskController@index')->name('home');
