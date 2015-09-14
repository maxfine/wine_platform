<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Template extends Model {

    public function posterThemes()
    {
        return $this->hasMany('App\Models\PosterTheme');
    }

}
