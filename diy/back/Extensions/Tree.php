<?php
/**
 * Created by PhpStorm.
 * User: konghansheng
 * Date: 2015/6/11
 * Time: 22:50
 */

class Tree {
    /**
     * ---------------------------------------------------------
     * 获取树形结构数组
     * ---------------------------------------------------------
     */
    public function getTree3($myid){
        $a = [];
        $arr = $this->arr;
        $pIdName = $this->pIdName;
        $idName = 'id';
        $childsName = 'childs';

        if(!isset($arr[$myid])) return false;
        foreach($arr as $v){
            if(isset($arr[$v[$pIdName]])){
                $arr[$v[$pIdName]][$childsName][] = &$arr[$v[$idName]];
            }else{
                $a[] = &$arr[$v[$idName]];
            }
        }

        return $arr;
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
        $idName = 'id';
        $childsName = 'childs';
        $funName = __FUNCTION__;

        $childs = $this->getChilds($rootId);
        if(empty($childs)) return null;
        foreach ($childs as $k => $v){
            $rescurTree = $this->$funName($v[$idName]);
            if( null !=   $rescurTree){
                $childs[$k][$childsName] = $rescurTree;
            }
        }
        return $childs;
    }


    /**
     * ---------------------------------------------------------
     * 递归取得tree
     * ---------------------------------------------------------
     * @param $data
     * @param int $myid
     * @return array
     */
    public function getTree2(&$data, $myid=0){
        $a = [];
        $pIdName = $this->pIdName;
        $idName = 'id';
        $childsName = 'childs';

        foreach($data as $k=>$v){
            if($v[$pIdName] == $myid){
                //删除
                unset($data[$k]);
                $v[$childsName] = $this->getTree2($data, $v['id']);
                $a[] = $v;
            }
        }

        return $a;
    }
}