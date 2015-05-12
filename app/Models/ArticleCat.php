<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleCat extends Model {

    /**
     * -----------------------------------------------------
     * 获取顶级栏目
     * -----------------------------------------------------
     */
    public static function getTopCats(){
        $cats = self::where(['parent_id'=>0,])->get();
        return $cats;
    }

    /**
     * -----------------------------------------------------
     * 获取次级栏目
     * -----------------------------------------------------
     */
    public static function getSonCats($id){
        $cats = self::where(['parent_id'=>$id,])->get();
        return $cats;
    }

    /**
     * -----------------------------------------------------
     * 获取所有栏目
     * -----------------------------------------------------
     * return [[id=>4, cat_name=>'xxx', childs=>[
     *      [id=>6, cat_name=>'xxx', childs=>[]], []
     * ]
     * ]]
     */
    public static function getChildCats($id){
        $cats = self::getSonCats($id);
        foreach($cats as $k=>$cat){
            $cats[$k]['childs'] = self::getChildCats($cat['id']);
        }
        return $cats;
    }

    /**
     * -----------------------------------------------------
     * 获取所有栏目
     * -----------------------------------------------------
     * return [[id=>4, cat_name=>'xxx', childs=>[
     *      [id=>6, cat_name=>'xxx', childs=>[]], []
     * ]
     * ]]
     */
    public static function getChilds($id){
        $cats = self::getSonCats($id);
        foreach($cats as $k=>$cat){
            $cats[] = self::getChilds($cat['id']);
        }
        return $cats;
    }

    /**
     * -----------------------------------------------------
     * 获取栏目深度
     * -----------------------------------------------------
     */
    public static function getLevel($id){
        $n = 0;
        if($id==0)return $n;
        while($id != 0 ){
            $cat = self::where(['id'=>$id])->get();
            $id = $cat[0]['parent_id'];
            $n++;
        }
        return $n;
    }

    /**
     * -----------------------------------------------------
     * 获取栏目select
     * -----------------------------------------------------
     */
    public static function getSelectCats($selectedId=0){
        $cats = self::getChilds(0);
        dump($cats);

        foreach($cats as $cat){
            $cat_name = $cat['cat_name'];
            $cat_name2 = '';
            //&nbsp;├ 
            $n = self::getLevel($cat['id']);
            while($n>1){
                $cat_name2 .= '&nbsp;';
                $n--;
            }
            if(self::getLevel($cat['id'])>1) $cat_name2 .= '├ ';
            $cat['cat_name'] = $cat_name2.$cat_name;
        }

        return $cats;
    }

}
