<?php namespace App\Http\Controllers;

/**
 * 前后台共用控制器
 * CommonController
 *
 * @author raoyc <raoyc2009@gmail.com>
 */
class CommonController extends Controller
{
    
    public function __construct()
    {
        $route = \Route::currentRouteAction();
        list($controller, $action) = explode('@', $route);
        $this->controller = $controller;
        $this->action = $action;
    }
}
