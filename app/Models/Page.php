<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {
    const commentType = 3;

    public function comments(){
        return $this->hasMany('App\Models\Comment','post_id')->where(['type'=>$this::commentType()])->get();
    }

    public static function commentType(){
        return self::commentType;
    }
}
