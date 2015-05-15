<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    public function articleCat(){
        return $this->belongsTo('ArticleCat');
    }

    public function comments(){
        return $this->hasMany('Comment')->where(['type'=>2])->get();
    }

    public function delete(){
        //删除此文章下的所有评论
        $this->comments()->delete();
        //删除自身
        Parent::delete();
    }
}
