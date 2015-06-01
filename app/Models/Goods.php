<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model {
    const commentType = 1;

    public function category(){
        return $this->belongsTo('App\Models\Category', 'cat_id');
    }

    public function banner(){
        return $this->belongsTo('App\Models\Brand');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store');
    }

    public function photos(){
        return $this->hasMany('App\Models\Photo');
    }
    
    public function comments(){
        return $this->hasMany('App\Models\Comment','post_id')->where(['type'=>$this::commentType()])->get();
    }

    public function attrs(){
        return $this->belongsToMany('App\Models\Attribute', 'goods_attrs', 'goods_id', 'attr_id');
    }

    public function goodsAttrs(){
        return $this->hasMany('App\Models\GoodsAttr', 'goods_id');
    }

    public function delete(){
        //删除此文章下的所有评论
        foreach($this->comments() as $comment){
            $comment->delete();
        }
        //删除自身
        parent::delete();
    }

    /**
     * -------------------------------------------
     * 评论类型
     * -------------------------------------------
     */
    public static function commentType(){
        return self::commentType;
    }
}
