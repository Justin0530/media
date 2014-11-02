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

Route::get('login', 'UserController@login');
Route::post('doLogin', 'UserController@doLogin');
Route::any('logout', 'UserController@logout');
Route::any('/common/data-list','CommonController@getDataList');
Route::any('/common/einfo','CommonController@getEInfoList');
Route::any('/common/frame','CommonController@frame');
Route::controller('common', 'CommonController');
Route::group(array('before' => 'auth'), function()
{


    Route::any('/', 'HomeController@showWelcome');

    //用户中心
    Route::any('/user/index', 'UserController@index');
    Route::any('/user/add', 'UserController@add');
    Route::any('/user/edit/{id}', 'UserController@edit')->where('id', '[0-9]+');
    Route::any('/user/del/{id}', 'UserController@del');

    //用户级别
    Route::any('/user/grade', 'UserController@grade');
    Route::any('/user/addGrade','UserController@addGrade');
    Route::any('/user/editGrade/{id}','UserController@editGrade')->where('id', '[0-9]+');
    Route::any('/user/lookGrade/{id}','UserController@lookGrade')->where('id', '[0-9]+');
    Route::any('/user/delGrade/{id}','UserController@delGrade');

    //菜单维护
    Route::any('/menu/index','MenuController@index');
    Route::any('/menu/add','MenuController@add');
    Route::any('/menu/edit/{id}','MenuController@edit')->where('id', '[0-9]+');
    Route::any('/menu/del/{id}','MenuController@del');

    //点位管理
    Route::any('/install/index','InstallController@index');
    Route::any('/install/add','InstallController@add');
    Route::any('/install/maintain', 'InstallController@maintain');
    Route::any('/install/maintainList', 'InstallController@maintainList');
    Route::any('/install/show/{id}','InstallController@show')->where('id', '[0-9]+');

    //工程管理
    Route::any('/project/save', 'ProjectController@getEquipment');
    Route::controller('project', 'ProjectController');

    //运维管理equipment/manager
    Route::any('/equipment/select','EquipmentController@select');
    Route::any('/equipment/manager/{id}','EquipmentController@manager')->where('id', '[0-9]+');
    Route::any('/equipment/maintain','EquipmentController@maintain');
    Route::any('/equipment/changeMaterial/{id}','EquipmentController@changeMaterial')->where('id', '[0-9]+');
    Route::any('/equipment/changeMaterialAjax/{id}','EquipmentController@changeMaterialAjax')->where('id', '[0-9]+');

    //物料管理
    Route::any('/material/index','MaterialController@index');

    //媒体管理
    Route::any('/media/add','MediaController@add');
    Route::any('/media/index','MediaController@index');
    Route::any('/media/picture','PictureController@index');
    Route::any('/media/picture/upload','PictureController@upload');
    Route::controller('/media/picture','PictureController');

    //客户信息管理 Custom/index
    Route::any('/custom/index','CustomController@index');
    Route::any('/custom/edit','CustomController@edit');
    Route::any('/custom/show','CustomController@edit');
    Route::any('/custom/editRecord','CustomController@editRecord');
    Route::any('/custom/record/{id}','CustomController@record')->where('id', '[0-9]+');
    Route::any('/custom/checker','CustomController@checker');

    //物料管理
    Route::resource('material', 'MaterialController');

    CrudController::initRouter(array(
        Province::$admin_config,
        City::$admin_config,
        Area::$admin_config,
        MaterialCat::$admin_config
    ));
});

