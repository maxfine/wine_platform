<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model {

    public function goods(){
        return $this->hasMany('App\Models\Goods');
    }

    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
