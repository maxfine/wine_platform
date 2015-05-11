<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Theater extends Model{

	public static $rules = array
	(
		'name' => 'required',
	);

	public function films()
	{
		return $this->belongsToMany('App\\Models\\Film', 'films_theaters');
	}

	public function boxOffice()
	{
		return $this->hasMany('App\\Models\\BoxOffice');
	}
}
