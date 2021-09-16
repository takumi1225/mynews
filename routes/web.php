<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//「http://XXXXXX.jp/XXX というアクセスが来たときに、 AAAControllerのbbbというAction に渡すRoutingの設定」を書いてみてください
Route::get('XXX', 'AAAController@bbb');

 //4.【応用】 前章でAdmin/ProfileControllerを作成し、add Action, edit Actionを追加しました。web.phpを編集して、getメソッドでadmin/profile/create にアクセスしたら ProfileController の add Action に、admin/profile/edit にアクセスしたら ProfileController の edit Action に割り当てるように設定してください

Route::group(['prefix' => 'admin','middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::post('news/create', 'Admin\NewsController@create');
    Route::get('profile/create', 'Admin\ProfileController@add')->middleware('auth');
    Route::post('profile/create', 'Admin\ProfileController@create');
    Route::post('profile/edit', 'Admin\ProfileController@update');
    Route::get('profile/edit', 'Admin\ProfileController@edit')->middleware('auth');
});

Route::group(['prefix' => 'admin'], function() {
    Route::get('news/create', 'Admin\NewsController@add')->middleware('auth');
    Route::post('news/create', 'Admin\NewsController@create')->middleware('auth');
    Route::get('news', 'Admin\NewsController@index')->middleware('auth'); // 追記
    Route::get('news/edit', 'Admin\NewsController@edit')->middleware('auth'); // 追記
    Route::post('news/edit', 'Admin\NewsController@update')->middleware('auth'); // 追記
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
