<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model {

    public function goods(){
        return $this->hasMany('App\Models\Brand');
    }

}
