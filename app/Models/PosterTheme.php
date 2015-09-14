<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosterTheme extends Model {

    public function template()
    {
        return $this->belongsTo('App\Models\Template');
    }

}
