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
     * 获取所有栏目,多维数组
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
     * 获取所有栏目,二维数组
     * -----------------------------------------------------
     * return [['id'=>1, 'cat_name'=>'xxx', ...], ['id'=>3, 'cat_name'=>'xxx', ..]]
     */
    public static function getChilds($id, &$list=[]){
        $cats = self::getSonCats($id);

        foreach($cats as $k=>$cat){
            $list[] = $cat;
            self::getChilds($cat['id'],$list);
        }
        return $list;
    }

    /**
     * -----------------------------------------------------
     * 获取栏目深度
     * -----------------------------------------------------
     * 顶级栏目深度为1
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

        foreach($cats as $cat){
            $cat_name = $cat['cat_name'];
            $prefix = '';
            //&nbsp;├ 
            $n = self::getLevel($cat['id']);
            $prefix = str_repeat('&nbsp;&nbsp;', $n-1);
            if(self::getLevel($cat['id'])>1) $prefix .= '├--';
            $cat['cat_name'] = $prefix.$cat_name;
        }

        return $cats;
    }

    /**
     * -----------------------------------------------------
     * 删除栏目
     * -----------------------------------------------------
     * 删除所有文章,包括子栏目文章, 删除所有子栏目
     */
    public static function delCat($id){
        $cats = self::getChilds($id);
        foreach($cats as $cat){
            //删除文章
            foreach($cat->articles as $_v){
                $_v->delete();
            }
            //删除栏目
            $cat->delete();
        }

        //删除本身
        parent::delete();
    }
    
    public function delete(){
        $cats = self::getChilds($this->id);
        foreach($cats as $cat){
            //删除文章
            foreach($cat->articles as $_v){
                $_v->delete();
            }

            //删除栏目
            $cat->delete();
        }

        foreach($this->articles as $_v){
            $_v->delete();
        }
        //删除本身
        parent::delete();
    }

    public function articles(){
        return $this->hasMany('App\Models\Article','cat_id');
    }

    
    /**
     * ----------------------------------------
     * 获取所有子栏目id,包括本身
     * ----------------------------------------
     */
    public function allCatIds(){
        $catIds = [];
        $catIds[] = $this->id;
        //获取所有子栏目
        $childCats = $this::getChildCats($this->id);       
        foreach($childCats as $cat){
            $catIds[] = $cat->id;
        }
        return $catIds;
    }

}
