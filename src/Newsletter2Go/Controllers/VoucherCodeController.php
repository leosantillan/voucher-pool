<?php

namespace Newsletter2Go\Controllers;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Carbon\Carbon;

/*
 * Just for DEMOSTRATION PURPOSES in this Controller I used Query
 * Builder instead Eloquent ORM as in the rest of the application.
 */
class VoucherCodeController extends Controller
{
	public function validateVoucherCode(Request $request, Response $response) : Response
	{
		$body = $request->getParsedBody();
		$db = $this->container->db;
		$voucher = $db->table('voucher_codes')
			->join('recipients','recipients.id','=','voucher_codes.recipient_id')
			->join('special_offers','special_offers.id','=','voucher_codes.special_offer_id')
			->select('voucher_codes.id', 'special_offers.discount')
			->where('voucher_codes.code', $body['voucher_code'])
			->where('recipients.email', $body['email'])
			->whereNull('voucher_codes.used_at')
			->get()
			->toArray();

		if (!$voucher) {
			return $response->withJson(['error' => 'Voucher Code not valid']);
	    }

	    $result = $db->table('voucher_codes')
	    	->where('id', $voucher[0]->id)
	    	->update(['used_at' => Carbon::now()]);

	    if (!$result) {
			return $response->withJson(['error' => 'Could not update Voucher information']);
	    }

	    return $response->withJson([
	    	'voucher_code' => $body['voucher_code'],
	    	'discount' => $voucher[0]->discount
	    ]);
	}

	public function getValidVouchers(Request $request, Response $response) : Response
	{
		$params = $request->getParams();

		if(!isset($params['email']) || empty($params['email'])) {
			return $response->withJson(['error' => 'Email param is required']);
		}

		$db = $this->container->db;
		$vouchers = $db->table('voucher_codes')
			->join('recipients','recipients.id','=','voucher_codes.recipient_id')
			->join('special_offers','special_offers.id','=','voucher_codes.special_offer_id')
			->select('special_offers.name', 'special_offers.discount', 'voucher_codes.code')
			->where('recipients.email', $params['email'])
			->whereNull('voucher_codes.used_at')
			->get()
			->toArray();

		if (!$vouchers) {
			return $response->withJson(['error' => 'Email does not have valid Voucher Codes']);
	    }

	    return $response->withJson($vouchers);
	}
}
