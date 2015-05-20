<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {

    public function goods(){
        return $this->belongsTo('App\Models\Goods');
    }
}
