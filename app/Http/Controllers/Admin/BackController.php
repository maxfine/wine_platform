<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController as CommonController;
use Config, BackNav;
use View;

/**
 * 后台共用控制器
 * BackController
 */
class BackController extends CommonController
{
    
    public function __construct()
    {
        //获取导航
        $backNavs = Config::get('back-nav');
        View::share('backNavs', $backNavs);

        foreach($backNavs as $nav){
            BackNav::addToMain($nav, 'back', false);
        }
        //BackNav::render('back', false, []);
    }
}
