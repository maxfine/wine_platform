<?php
/**
 * Created by max_fine@qq.com.
 * User: max_fine
 * Date: 2015/6/9
 * Time: 15:23
 * 树结构
 */

namespace App\Exceptions;


class CategoryTree {
    //生成树结构所需要的二维数组
    public $arr = [];
    //修饰符,可以换成图片
    public $icon = ['│','├','└'];
    //空格
    public $nbsp = '&nbsp;';

    /**
     * ---------------------------------------------------------
     * 构造函数, 初始化
     * ---------------------------------------------------------
     * @param array $arr
     * $arr =
     * [
 *          1=>['id'=>1, 'parentid'=0, 'name'=>'一级栏目一'],
 *          2=>['id'=>2, 'parentid'=0, 'name'=>'一级栏目二'],
 *          3=>['id'=>3, 'parentid'=1, 'name'=>'二级栏目一'],
 *          4=>['id'=>4, 'parentid'=1, 'name'=>'二级栏目二'],
 *          5=>['id'=>5, 'parentid'=4, 'name'=>'三级栏目一'],
     * ]
     */
    public function __construct($arr = []){
        $this->arr = $arr;
    }

    /**
     * ---------------------------------------------------------
     * 获取父级数组
     * ---------------------------------------------------------
     * @param $myid
     */
    public function getParent($myid){

    }

    /**
     * ---------------------------------------------------------
     * 获取子级数组
     * ---------------------------------------------------------
     * @param $myid
     */
    public function getChild($myid){

    }

    /**
     * ---------------------------------------------------------
     * 获取树形结构数组
     * ---------------------------------------------------------
     */
    public function getTree(){

    }

    public function getChildJson(){

    }

    public function getPos(){

    }

}





















