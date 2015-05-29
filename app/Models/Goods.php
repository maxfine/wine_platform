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

    public function delete(){
        //删除此文章下的所有评论
        foreach($this->comments() as $comment){
            $comment->delete();
        }
        //删除自身
        Parent::delete();
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
