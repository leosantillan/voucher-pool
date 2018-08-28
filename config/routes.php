<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Welcome to Newsletter2Go Voucher Pool API");
    return $response;
});

// Recipients
$app->get ('/recipients', 				'RecipientController:index');

// Special Offers
$app->get ('/special_offers', 			'SpecialOfferController:index');
$app->post('/special_offers', 			'SpecialOfferController:create');

// Voucher Codes
$app->post('/validate_voucher_code', 	'VoucherCodeController:validateVoucherCode');
$app->get ('/voucher_codes', 			'VoucherCodeController:getValidVouchers');
