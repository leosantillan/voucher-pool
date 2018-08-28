<?php  

namespace Newsletter2Go\Models;

use \Illuminate\Database\Eloquent\Model;

class Recipient extends Model 
{  
	protected $table = 'recipients';

	protected $fillable = [
		'name',
		'email'
	]; 
}
