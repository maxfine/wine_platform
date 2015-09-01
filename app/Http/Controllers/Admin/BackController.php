<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommonController as CommonController;
use App\Repositories\Tree;
use Config, BackNav;
use View;

/**
 * 后台共用控制器
 * BackController
 */
class BackController extends CommonController
{
    protected $items;
    protected $navs;
    
    public function __construct()
    {
        //获取导航
        $backNavs = Config::get('back-nav2');
        $tree = new Tree($backNavs, 'parent_id', 'title');
        //$backNavs = $tree->getTreeView(1);
        View::share('tree', $tree);

        //BackNav::render('back', false, []);
    }

    private function navs(){
        $html = '';
        //构建无限极导航html
        return $html;
    }
}
