<?php
/**
 * Created by 正言网络科技
 * User: max_fine@qq.com
 * Date: 2015/6/9
 * Time: 15:23
 * 单个: 获取父数组
 * 纵向, 横向: 获取当前位置数组, 获取子数组, 获取字数组json
 * 整体: 获取树结构数组, 获取树结构html
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
     * @param $myid == 栏目id
     * @return array|bool
     */
    public function getChilds($myid){
        $newArr = [];
        $pIdName = $this->pIdName;

        if(is_array($this->arr)){
            foreach($this->arr as $k=>$a){
                if($a[$pIdName] == $myid){
                    $newArr[$k] = $a;
                }
            }
        }

        return $newArr ? $newArr : false;
    }

    /**
     * -----------------------------------------------------------
     * 根据数组key获取当前位置二维数组
     * -----------------------------------------------------------
     * @param $myid 可以为0, 不要用empty判断
     * @return array|bool
     */
    public function getPos($myid, &$newArr = []){
        $a = [];
        $idName = 'id';
        $pIdName = $this->pIdName;
        $arr = $this->arr;
        $funName = __FUNCTION__;

        if(!isset($myid)) return false;

        $key = $this->getKeyById($myid);
        if(!isset($arr[$key]))return false;
        $newArr[] = $arr[$key];
        $pid = $arr[$key][$pIdName];
        $pkey = $this->getKeyById($pid);
        if($pkey !== false && is_array($arr[$pkey])){
            $this->$funName($pid, $newArr);
        }
        //重组
        if(is_array($newArr)){
            krsort($newArr);
            foreach($newArr as $v){
                $a[$v[$idName]] = $v;
            }
        }

        return $a ? $a : false;
    }

    /**
     * ----------------------------------------------------------
     * 递归建树
     * ----------------------------------------------------------
     * @param $root_id
     * @return null
     */
    public function getTree($rootId){
        $pIdName = $this->pIdName;
        //字段名
        $idName = 'id';
        $childsName = 'childs';
        //本方法,递归使用,避免修改了方法名时递归方法名也要修改
        $funName = __FUNCTION__;

        $childs = $this->getChilds($rootId);
        if(empty($childs)) return false;
        foreach ($childs as $k => $v){
            $rescurTree = $this->$funName($v[$idName]);
            if( null !=   $rescurTree){
                $childs[$k][$childsName] = $rescurTree;
            }
        }
        return $childs;
    }

    public function getTreeCategory($myid, $str, $str2, $sid = 0, $adds = ''){
        static $ret = '';
        $pIdName = $this->pIdName;
        //字段名
        $idName = 'id';
        $childsName = 'childs';
        //本方法,递归使用,避免修改了方法名时递归方法名也要修改
        $funName = __FUNCTION__;

        $number = 1;
        $childs = $this->getChilds($myid);
        if(empty($childs)) return false;
        if(is_array($childs)){
            $total = count($childs);
            foreach ($childs as $k=>$v) {
                $nstr = '';

                $selected = $this->have($sid, $id) ? 'selected' : '';
                @extract($v);
                if(empty($html_disabled)){
                    $nstr = eval("\$nstr = \"$str\"");
                }else{
                    $nstr = eval("\$nstr = \"$str2\"");
                }
                $ret .= $nstr;
                $this->$funName($v[$idName]);
            }
        }
    }

    /**
     * ---------------------------------------------------------------
     * 获取子栏目json
     * ---------------------------------------------------------------
     * @param $myid
     * @return mixed
     */
    public function getChildsJson($myid, $str = ''){
        $data = [];
        $pIdName = $this->pIdName;
        $catName = $this->catName;
        //字段名
        $idName = 'id';

        $childs = $this->getChilds($myid);
        $n = 0;
        if(is_array($childs)){
            foreach ($childs as $v) {
                $data[$n][$idName] = $v[$idName];
                if($this->getChilds($v[$idName])){
                    $data[$n]['liclass'] = 'hasChild';
                    $data[$n]['text'] = $v[$catName];
                }else{
                    if(isset($str) && !empty($str)){
                        @extract($v);
                        eval("\$data[$n]['text'] = \"$str\""); //$str = $a.$b;
                    }else{
                        $data[$n]['text'] = $v[$catName];
                    }
                }

                $n++;
            }
        }

        return json_encode($data);
    }

    /**
     * ----------------------------------------------------------------
     * 根据id获取key
     * ----------------------------------------------------------------
     * @param $myid
     * @return bool|int|null|string
     */
    public function getKeyById($myid){
        $key = false;
        $arr = $this->arr;
        $idName = 'id';
        $pIdName = $this->pIdName;

        if(is_array($arr)){
            foreach($arr as $k=>$v){
                if($v[$idName] == $myid){
                    $key = $k;
                    break;
                }
            }
        }

        return $key;
    }


}





















