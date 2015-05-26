<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');


/**
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
**/

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function()
{
    //后台首页
    Route::get('/', 'AdminHomeController@index');
    //文章栏目
    Route::resource('article/cats', 'ArticleCatsController');
    //文章
    Route::resource('articles', 'ArticlesController');
    Route::get('articles/{catId}/list', 'ArticlesController@getList');
    //单页
    Route::resource('pages', 'PagesController');
    //评论
    Route::resource('comments', 'CommentsController');
    Route::get('comments/{post_id}/{type}/create', 'CommentsController@create')->where(['id'=>'[0-9]+']);
    Route::get('comments/{post_id}/{type}/list', 'CommentsController@commentList')->where(['post_id'=>'[0-9]+']);
    //Route::get('pages/{id?}', 'PagesController@show')->where(array('id'=>'[0-9]+'));

    //商品栏目
    Route::resource('goods/cats', 'GoodsCatsController');
    //商品
    Route::resource('goods', 'GoodsController');
    //商品图册
    //Route::match(['get', 'post'], 'goods/upload_image/{file_name}', 'GoodsController@uploadImage');
    //品牌
    //Route::resource('brands', 'BrandsController');
    //商品类型
    //Route::resource('goods/types', 'GoodsTypesController');
    //商品属性
    //Route::resource('attrs', 'AttrsController');
    //Route::resource('goods/attrs', 'GoodsAttrsController');
});
//Route::get('admin/login', 'Auth\AuthController@getAdminLogin');
//文件上传
Route::group(['prefix' => 'file', 'namespace' => 'File'], function(){
    //Route::resource('photos', 'PhotosController');
    Route::match(['get', 'post'], 'photos/upload_image/{fileName}', 'PhotosController@uploadImage');
    Route::delete('photos/delete_image', 'PhotosController@deleteImage');
    Route::get('photos/delete_image', 'PhotosController@deleteImage');
    Route::resource('photos', 'PhotosController');
});
