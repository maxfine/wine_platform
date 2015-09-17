<?php namespace App\Http\Controllers\Member;

use App\Http\Requests;
use App\Http\Controllers\CommonController as CommonController;

use Illuminate\Http\Request;
use App\Repositories\Tree;
use Config, BackNav;
use View;


class MemberController extends CommonController {
    protected $items;
    protected $navs;

    public function __construct(){
        $this->middleware('auth');
        //获取导航
        $backNavs = Config::get('member-nav');
        $tree = new Tree($backNavs, 'parent_id', 'title');
        //$backNavs = $tree->getTreeView(1);
        View::share('tree', $tree);
        parent::__construct();
    }

    private function navs(){
        $html = '';
        //构建无限极导航html
        return $html;
    }
}
