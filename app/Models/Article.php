<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {

    public function articleCat(){
        return $this->belongsTo('ArticleCat');
    }

}
