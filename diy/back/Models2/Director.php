<?php namespace App;

use Illuminate\Database\Eloquent\Model;
class Director extends Model {

	protected $with = array('films');

	public static $rules = array
	(
		'first_name' => 'required',
		'last_name' => 'required',
		'salary' => 'required',
	);

	public function films()
	{
		return $this->hasMany('App\\Film');
	}

	public function getNameAttribute()
	{
		return $this->getAttribute('first_name') . ' ' . $this->getAttribute('last_name');
	}

	public function getFormattedSalaryAttribute()
	{
		return '$'.number_format($this->getAttribute('salary'), 2);
	}

	public function getNumFilmsAttribute()
	{
		return count($this->films);
	}
}
