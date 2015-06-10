<?php
/**
 * Created by max_fine@qq.com.
 * User: max_fine
 * Date: 2015/6/9
 * Time: 15:23
 * 树结构
 */

namespace App\Extensions;


class CategoryTree {
    //生成树结构所需要的二维数组
    public $arr = [];
    //修饰符,可以换成图片
    public $icon = ['│','├','└'];
    //空格
    public $nbsp = '&nbsp;';

    public $pIdName = '';

    public $catName = '';

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
    public function __construct($arr = [], $pIdName = 'parent_id', $catName = 'cat_name'){
        $this->arr = $arr;
        $this->pIdName = $pIdName;
        $this->catName = $catName;
        $this->ret = '';
        return is_array($arr);
    }

    /**
     * ---------------------------------------------------------
     * 获取父级数组
     * ---------------------------------------------------------
     * @param $myid
     * @return array|bool
     */
    public function getParent($myid){
        $newArr = [];
        $pIdName = $this->pIdName;

        if(!isset($this->arr[$myid]))return false;
        $pid = $this->arr[$myid][$pIdName];
        if(!isset($this->arr[$pid]))return false;
        $pid = $this->arr[$pid][$pIdName];
        if(is_array($this->arr)){
            foreach($this->arr as $id=>$a){
                if($a[$pIdName] == $pid)$newArr[] = $this->arr[$id];
            }
        }

        return $newArr;
    }

    /**
     * ---------------------------------------------------------
     * 获取子级数组
     * ---------------------------------------------------------
     * @param $myid
     * @return array|bool
     */
    public function getChild($myid){
        $newArr = [];
        $pIdName = $this->pIdName;

        if(!isset($this->arr[$myid]))return false;

        if(is_array($this->arr)){
            foreach($this->arr as $id=>$a){
                if($a[$pIdName] == $myid){
                    $newArr[$id] = $a;
                }
            }
        }

        return $newArr ? $newArr : false;
    }

    /**
     * -----------------------------------------------------------
     * 获取当前位置数组
     * -----------------------------------------------------------
     * @param $myid
     * @param $newArr
     * @return array|bool
     */
    public function getPos($myid, &$newArr){
        $a = [];
        $pIdName = $this->pIdName;

        if(!isset($this->arr[$myid]))return false;
        $newArr[] = $this->arr[$myid];
        $pid = $this->arr[$myid][$pIdName];
        if(isset($this->arr[$pid])){
            $this->getPos($pid, $newArr);
        }
        //重组
        if(is_array($newArr)){
            krsort($newArr);
            foreach($newArr as $v){
                $a[$v['id']] = $v;
            }
        }

        return $a;
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
}





















