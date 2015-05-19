<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model {
    const commentType = 1;

    public static function commentType(){
        return self::commentType;
    }
}
