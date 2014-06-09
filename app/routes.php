<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::any('/', 'HomeController@showWelcome');
Route::get('login', 'UserController@login');
Route::post('doLogin', 'UserController@doLogin');
Route::any('logout', 'UserController@logout');

Route::group(array('before' => 'auth'), function()
{
    //用户中心
    Route::any('/user/index', 'UserController@index');
    Route::any('/user/add', 'UserController@add');
    Route::any('/user/edit/{id}', 'UserController@edit')->where('id', '[0-9]+');
    Route::any('/user/del/{id}', 'UserController@del');
    //用户级别
    Route::any('/user/grade', 'UserController@grade');
    Route::any('/user/addGrade','UserController@addGrade');

    //菜单维护
    Route::any('/menu/index','MenuController@index');
});

