<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoxOffice extends Model{

	protected $table = 'box_office';

	public static $rules = array
	(
		'revenue' => 'required|numeric',
		'film_id' => 'required|integer',
		'theater_id' => 'required|integer',
	);

	public function film()
	{
		return $this->belongsTo('App\\Models\\Film');
	}

	public function theater()
	{
		return $this->belongsTo('App\\Models\\Theater');
	}

	public function getFormattedRevenueAttribute()
	{
		return '$'.number_format($this->getAttribute('revenue'), 2);
	}
}
