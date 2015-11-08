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
    //进行第三方支付网站跳转
    \Omnipay::setGateway('Alipay_Bank');

    $options = array(
        'out_trade_no' => '2014010122390002', //共有
        'subject'      => 'test', //共有
        'total_fee' => 0.03, //即时支付接口总费用
        'price'        => '0.01', //担保交易商品单价
        'quantity'     => '2', //担保交易商品数量
        'defaultBank' => 'CCB', //网银支付网关
    );
    $response = \Omnipay::purchase($options)->send(); //request->response
    $response->redirect();
    //$redirectData = $response->getRedirectData();
    //dd($redirectData);

    /**
     *正则匹配工具类测试
    $regexTool = new \App\Repositories\RegexTool();
    dump($regexTool->isEmail('max_fine@qq.com'));
    */
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

Route::get('/test3', function(){
    //dd(app());
    $class = get_class(app());
    //$reflection = new \ReflectionClass ($class) ;

    dd(print_r(pathinfo("http://jiu.znyes.com/testweb/test.txt?dd")));
});

Route::get('/test4', function(\App\Repositories\PayAccountRepository $pay){
    //\Event::fire(new App\Events\ThingWasDone);
    //\Event::subscribe(new App\Handlers\Events\UserEventHandler);
    //\Event::fire(new App\Events\UserLoggedIn(user('object')));
    //$user = App\Models\User::find(2);
    //\Event::fire(new App\Events\UserPointUpdate($user));
    //dd($pay);
});

/**
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
**/

/**
 * -----------------------------------------------------------------------------------------
 * 基本权限控制
 * -----------------------------------------------------------------------------------------
 */
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');
Route::post('auth/check_email', 'Auth\AuthController@checkEmail');

/**
 * -----------------------------------------------------------------------------------------
 * 用户
 * -----------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'user', 'namespace' => 'User'], function()
{
    //todo
});

/**
 * -----------------------------------------------------------------------------------------
 * 前台
 * -----------------------------------------------------------------------------------------
 */
Route::get('/', 'HomeController@index');

/**
 * -----------------------------------------------------------------------------------------
 * 功能模块dome
 * -----------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'dome', 'namespace' => 'Dome'], function()
{
    //支付模块dome
    Route::post('respond/{code}', 'RespondController@respondPost');
    Route::get('respond/{code}', 'RespondController@respondGet');
    Route::get('payments/create_check_alert', 'PaymentsController@createCheckAlert');
    Route::resource('payments', 'PaymentsController');

    //上传模块dome
    Route::post('files/upload', 'FilesController@upload');
});

/**
 * -----------------------------------------------------------------------------------------
 * 后台管理
 * -----------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'admin'], function()
{
    //后台
    Route::get('/', ['as' => 'admin', 'uses' => 'AdminHomeController@index']);
    //后台首页内容页
    Route::get('index_content', 'AdminHomeController@indexContent');
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

    //用户以及权限管理
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('managers', 'ManagersController');
    Route::resource('members', 'MembersController');
});

/**
 * --------------------------------------------------------------------------------------
 * 会员系统
 * --------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'member', 'namespace' => 'Member', 'middleware' => 'auth'], function(){
    Route::get('/', 'MemberHomeController@index');
    Route::resource('poster/themes', 'Poster\ThemesController');
    Route::get('poster/themes/renew_edit/{id}', 'Poster\ThemesController@renewEdit');
    Route::post('poster/themes/renew/{id}', 'Poster\ThemesController@renew');
    Route::resource('pay_accounts', 'PayAccountsController');
    Route::get('pay_accounts/pay_config/{id}', 'PayAccountsController@payConfig');

    //Route::resource('pay/recharge', 'Pay\RechargeController');
    //Route::get('pay/recharge/respond_get', 'Pay\RechargeController@respondGet');
    //Route::post('pay/recharge/respond_post', 'Pay\RechargeController@respondPost');
});

/**
 * --------------------------------------------------------------------------------------
 * 支付相关
 * --------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'pay', 'namespace' => 'Pay'], function() {
    Route::resource('payment', 'PaymentController');
    //Route::resource('respond', 'RespondController');
    Route::get('respond_get/{code}', 'RespondController@respondGet');
    Route::post('respond_post/{code}', 'RespondController@respondPost');
});

/**
 * --------------------------------------------------------------------------------------
 * 广告主题系统
 * --------------------------------------------------------------------------------------
 */
Route::group(['prefix' => 'poster', 'namespace' => 'Poster'], function(){
    Route::resource('themes', 'ThemesController');
    Route::get('themes/get_js/{id}', 'ThemesController@getJs');
    Route::get('themes/jsonp_callback/{callback}/{paramStr}', 'ThemesController@jsonpCallback');
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

