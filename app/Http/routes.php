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

Route::get('test', function(){
    $a = [];
    $arr =
        [
            ['id'=>1, 'parent_id'=>0, 'cat_name'=>'一级栏目一'],
            ['id'=>3, 'parent_id'=>0, 'cat_name'=>'一级栏目二'],
            ['id'=>4, 'parent_id'=>1, 'cat_name'=>'二级栏目一'],
            ['id'=>6, 'parent_id'=>1, 'cat_name'=>'二级栏目二'],
            ['id'=>8, 'parent_id'=>6, 'cat_name'=>'三级栏目一'],
            ['id'=>12, 'parent_id'=>8, 'cat_name'=>'四级栏目一'],
            ['id'=>14, 'parent_id'=>3, 'cat_name'=>'二级级栏目一'],
        ];
    $tree = new App\Extensions\CategoryTree($arr, 'parent_id', 'cat_name');
    $myid = 1;
    $newArr = [['id'=>14, 'parent_id'=>3, 'cat_name'=>'二级级栏目一'],];

    $str = "<option value='\$id' \$selected >\$spacer\$cat_name</option>";
    $aaa = $tree->getTreeCategory(1, $str, $str, 6);
    echo '<select name="cat">';
    echo "<option value='0'>顶级栏目</option>";
    echo $aaa;
    echo '</select>';
});

Route::get('/test2', function(){
    DB::listen(function($sql, $bindings, $time)
    {
        dump($sql);
    });
    $data = \App\Model\Tag::find(68262);
    echo '<select name="cat">';
    echo $data;
    echo '</select>';

    //return $data;
});

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
    Route::get('comments/create/{post_id}/{type}', 'CommentsController@create')->where(['id'=>'[0-9]+']);
    Route::get('comments/list/{post_id}/{type}', 'CommentsController@commentList')->where(['post_id'=>'[0-9]+']);
    //Route::get('pages/{id?}', 'PagesController@show')->where(array('id'=>'[0-9]+'));

    //商品栏目
    Route::resource('goods/cats', 'GoodsCatsController');
    //商品
    Route::resource('goods', 'GoodsController');
    Route::post('goods/update/{id}', 'GoodsController@update');
    //商品图册
    //Route::match(['get', 'post'], 'goods/upload_image/{file_name}', 'GoodsController@uploadImage');
    //品牌
    //Route::resource('brands', 'BrandsController');
    //商品类型
    Route::resource('goods_types', 'GoodsTypesController');
    //商品属性
    Route::get('attrs/list/{typeId}', 'AttributesController@getList');
    Route::match(['get', 'post'], 'attrs/ajax_list/{typeId}/{goodsId?}', 'AttributesController@ajaxList');
    Route::get('attrs/create/{typeId?}', 'AttributesController@create');
    Route::resource('attrs', 'AttributesController');
    //Route::resource('goods_attrs', 'GoodsAttrsController');
});
//Route::get('admin/login', 'Auth\AuthController@getAdminLogin');
//文件上传
Route::group(['prefix' => 'file', 'namespace' => 'File'], function(){
    //Route::resource('photos', 'PhotosController');
    Route::match(['get', 'post'], 'photos/upload_image/{fileName}', 'PhotosController@uploadImage');
    Route::delete('photos/delete_image', 'PhotosController@deleteImage');
    Route::get('photos/delete_image', 'PhotosController@deleteImage');
    Route::post('photos/ajax_del/{id}', 'PhotosController@ajaxDel');
    Route::resource('photos', 'PhotosController');
});
