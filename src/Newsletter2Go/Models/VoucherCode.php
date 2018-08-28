<?php  

namespace Newsletter2Go\Models;

use \Illuminate\Database\Eloquent\Model;

class VoucherCode extends Model 
{  
	protected $table = 'voucher_codes';
	
	protected $fillable = [
		'special_offer_od',
		'recipient_id',
		'code'
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];
}
