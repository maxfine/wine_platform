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

    /**
     * -------------------------------------------
     * 评论类型
     * -------------------------------------------
     */
    public static function commentType(){
        return self::commentType;
    }
}
