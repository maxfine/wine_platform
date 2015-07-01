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

namespace App\Repositorise;


class Tree {
    //生成树结构所需要的二维数组
    public $arr = [];
    //修饰符,可以换成图片
    public $icon = ['│','├','└'];
    //空格
    public $nbsp = '&nbsp;';

    public $idName = '';

    public $pIdName = '';

    public $catName = '';

    public $childsName = '';

    /**
     * ---------------------------------------------------------
     * 构造函数, 初始化
     * ---------------------------------------------------------
     * @param array $arr
     * $arr =
     * [
     *          1=>['id'=>1, 'parent_id'=0, 'cat_name'=>'一级栏目一'],
     *          2=>['id'=>2, 'parent_id'=0, 'cat_name'=>'一级栏目二'],
     *          3=>['id'=>3, 'parent_id'=1, 'cat_name'=>'二级栏目一'],
     *          4=>['id'=>4, 'parent_id'=1, 'cat_name'=>'二级栏目二'],
     *          5=>['id'=>5, 'parent_id'=4, 'cat_name'=>'三级栏目一'],
     * ]
     */
    public function __construct($arr = [], $pIdName = 'parent_id', $catName = 'cat_name', $idName = 'id', $childsName = 'childs'){
        $this->arr = $arr;
        $this->idName = $idName;
        $this->childsName = $childsName;
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
        $idName = $this->idName;
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
        //主键字段名
        $idName = $this->idName;
        $childsName = $this->childsName;
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

    /**
     * -----------------------------------------------------------------------
     * 获取栏目tree(html)
     * -----------------------------------------------------------------------
     * @param $myid
     * @param $str = '<option value="$id" $selected >$spacer.$cat_name</option>'
     * @param $str2
     * @param int $sid
     * @param string $adds
     * @return bool|string
     */
    public function getTreeCategory($myid, $str = '', $str2 = '', $sid = 0, $adds = ''){
        $pIdName = $this->pIdName;
        //字段名
        $idName = $this->idName;
        $childsName = $this->childsName;
        //本方法,递归使用,避免修改了方法名时递归方法名也要修改
        $funName = __FUNCTION__;

        $number = 1;
        $childs = $this->getChilds($myid);
        if(empty($childs)) return false;
        if(is_array($childs)){
            $total = count($childs);
            foreach ($childs as $k=>$v) {
                $nstr = '';

                $j=$k='';
                if($number==$total){
                    $j .= $this->icon[2];
                }else{
                    $j .= $this->icon[1];
                    $k = $adds ? $this->icon[0] : '';
                }
                $spacer = $adds ? $adds.$j : '';


                $selected = $this->have($sid, $v[$idName]) ? 'selected' : '';
                @extract($v); //['id'=> $id, 'parent_id'=>$parent_id, 'cat_name'=>$cat_name]
                if(!isset($html_disabled) || empty($html_disabled)){
                    eval("\$nstr = \"$str\";");
                }else{
                    eval("\$nstr = \"$str2\";");
                }
                $this->ret .= $nstr;
                $this->$funName($v[$idName], $str, $str2, $sid, $adds.$k.'&nbsp');
            }
        }

        return $this->ret;
    }

    /**
     * ---------------------------------------------------------------------------------
     * 是否选中
     * ---------------------------------------------------------------------------------
     * @param $list = '0,1,2,5'
     * @param $item = '2'
     * @return bool|int = 5
     */
    private  function have($list, $item){
        return(strpos(',,'.$list.',', ','.$item.',')); //',,'避免返回0, 如果$item为空, 则返回0
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
        $idName = $this->idName;

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
        $idName = $this->idName;
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
