<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    const commentType = 2;

    public function articleCat(){
        return $this->belongsTo('App\Models\ArticleCat');
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
        parent::delete();
    }

    public static function commentType(){
        return self::commentType;
    }

    public function type(){
        return 2;
    }
}
