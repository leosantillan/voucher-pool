<?php

namespace Newsletter2Go\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Carbon\Carbon;
use Newsletter2Go\Traits\VoucherTrait;
use Newsletter2Go\Models\SpecialOffer;
use Newsletter2Go\Models\Recipient;
use Newsletter2Go\Models\VoucherCode;
use Illuminate\Database\Capsule\Manager as DB;

class SpecialOfferController extends Controller
{
	use VoucherTrait;

	public function index(Request $request, Response $response) : Response
	{
		return $response->withJson(SpecialOffer::all());
	}

	public function create(Request $request, Response $response) : Response
	{
		$body = $request->getParsedBody();

		DB::beginTransaction();

		if (Carbon::now()->gt(Carbon::parse($body['expiration_date']))) {
			return $response->withJson(['error' => 'Expiration date has passed']);
		}

		$specialOffer = new SpecialOffer;
		$specialOffer->fill($body);

		try {
		    $specialOffer->save();
		} catch(\Exception $e) {
	    	return $response->withJson(['error' => $e->getMessage()]);
	    }

	    $recipients = Recipient::all();

    	if (count($recipients) <= 0) {
    		DB::rollback();
	    	return $response->withJson(['error' => 'No recipients']);
	    }

    	foreach($recipients as $recip) {
    		$vouchers[] = [
		    	'special_offer_id' => $specialOffer->id, 
		    	'recipient_id' => $recip->id, 
		    	'code' => $this->generateVoucherCode()
		    ];
    	}

    	try {
    		$result = VoucherCode::insert($vouchers);
    	} catch(\Exception $e) {
    		DB::rollback();
	    	return $response->withJson(['error' => $e->getMessage()]);
	    }

	    DB::commit();

	    return $response->withJson(['result' => 'OK']);
	}
}
