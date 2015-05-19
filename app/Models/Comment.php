<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    static private $tableObjs = [];

    public function article(){
        if($this->type==2) return $this->belongsTo('App\Models\Article','post_id');
    }

    public function goods(){
        if($this->type==1)return $this->belongsTo('App\Models\Goods','post_id');
    }

    /**
     * ------------------------------------------------
     * 是否能新建
     * ------------------------------------------------
     */
    public static function canBuild($post_id, $type){
        if(self::tableObj($post_id, $type))return true;
    }

    /**
     * -------------------------------------------------
     * 获取正确的评论对象
     * -------------------------------------------------
     */
    public static function tableObj($post_id, $type){
        //方法一,让客户端控制
        //Comment::addTableObj('\App\Models\Article');
        //Comment::addTableObj('\App\Models\Goods');
        /**
        foreach(self::$tableObjs as $tobj){
            if($type == $tobj::commentType() && $post_id)return $tobj::find($post_id);
        }
        */

        //方法二,服务器控制
        if($type==1)return Goods::find($post_id);
        elseif($type==2)return Article::find($post_id);
        elseif($type==3)return Page::find($post_id);
        return null;
    }

    /**
     * ------------------------------------------------
     * 添加评论对象
     * ------------------------------------------------
     */
    public static function addTableObj($tableObj){
        if(!in_array($tableObj, self::$tableObjs)){
            self::$tableObjs[] = $tableObj;
        }
    }
}
