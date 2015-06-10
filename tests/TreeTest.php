<?php
/**
 * Created by PhpStorm.
 * User: konghansheng
 * Date: 2015/6/10
 * Time: 1:36
 */

class TreeTest extends TestCase{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testGetParent()
    {
        $response = $this->call('GET', '/');

        $parentArr = [];
        $arr =
            [
                1=>['id'=>1, 'parentid'=>0, 'name'=>'一级栏目一'],
                2=>['id'=>2, 'parentid'=>0, 'name'=>'一级栏目二'],
                3=>['id'=>3, 'parentid'=>1, 'name'=>'二级栏目一'],
                4=>['id'=>4, 'parentid'=>1, 'name'=>'二级栏目二'],
                5=>['id'=>5, 'parentid'=>4, 'name'=>'三级栏目一'],
            ];
        $tree = new App\Extensions\CategoryTree($arr);
        $myid = 4;

        if(null !== $tree->getParent($myid)) {
            $parentArr = $tree->getParent($myid);
        }else{
            return false;
        }
        $istrue = $parentArr ==
            [
                0=>['id'=>1, 'parentid'=>0, 'name'=>'一级栏目一'],
                1=>['id'=>2, 'parentid'=>0, 'name'=>'一级栏目二'],
            ];

        $this->assertEquals(true, $istrue);
    }

    public function testGetChild(){
        $parentArr = [];
        $arr =
            [
                1=>['id'=>1, 'parent_id'=>0, 'cat_name'=>'一级栏目一'],
                2=>['id'=>2, 'parent_id'=>0, 'cat_name'=>'一级栏目二'],
                3=>['id'=>3, 'parent_id'=>1, 'cat_name'=>'二级栏目一'],
                4=>['id'=>4, 'parent_id'=>1, 'cat_name'=>'二级栏目二'],
                5=>['id'=>5, 'parent_id'=>4, 'cat_name'=>'三级栏目一'],
            ];
        $tree = new App\Extensions\CategoryTree($arr, 'parent_id', 'cat_name');
        $myid = 1;

        if(null !== $tree->getChild($myid)) {
            $childArr = $tree->getChild($myid);
        }else{
            return false;
        }

        $istrue = $childArr ==
            [
                3=>['id'=>3, 'parentid'=>1, 'name'=>'二级栏目一'],
                4=>['id'=>4, 'parentid'=>1, 'name'=>'二级栏目二'],
            ];

        $this->assertEquals(true, $istrue);
    }
}