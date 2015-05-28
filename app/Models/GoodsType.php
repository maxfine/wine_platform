<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsType extends Model {

    public function goods(){
        return $this->hasMany('App\Models\Goods', 'type_id');
    }

    public function attributes(){
        return $this->hasMany('App\Models\Attribute', 'type_id');
    }

}
