<?php namespace App\Caches;
use Cache;
use Db;
use Config;

/**
 * 数据缓存
 * 缓存导航数据, 分类数据, 通用内容
 * User: maxfine<max_fine@qq.com>
 * Date: 2015/9/9
 * Time: 9:16
 */

class DataCache {
    public static function cacheContent(){
        //todo
    }

    public static function cacheBackNav(){
        $navs = [];
        //1. 获取后台导航
        $navs = Config::get('back-nav');

        //2. 缓存后台导航
        if(!empty($navs)){
            //todo
        }

        //3. 返回
        return true;
    }
}