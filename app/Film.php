<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class Film extends Model{

	public static $rules = array
	(
		'name' => 'required',
		'release_date' => 'required',
		'director_id' => 'required',
	);

	public function director()
	{
		return $this->belongsTo('Director');
	}

	public function actors()
	{
		return $this->belongsToMany('Actor', 'actors_films');
	}

	public function theaters()
	{
		return $this->belongsToMany('Theater', 'films_theaters');
	}

	public function boxOffice()
	{
		return $this->hasMany('BoxOffice');
	}

	public function getDirectorNameAttribute()
	{
		return isset($this->director->name) ? $this->director->name : '';
	}
}
