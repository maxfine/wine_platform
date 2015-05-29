<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model {

    public function goodsType(){
        return $this->belongsTo('App\Models\GoodsType' ,'type_id');
    }

}
