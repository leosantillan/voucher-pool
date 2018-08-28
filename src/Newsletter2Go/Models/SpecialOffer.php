<?php  

namespace Newsletter2Go\Models;

use \Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model 
{  
	protected $table = 'special_offers';
	
	protected $fillable = [
		'name',
		'discount',
		'expiration_date'
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];
}
