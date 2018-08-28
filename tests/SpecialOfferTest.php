<?php

use PHPUnit\Framework\TestCase;

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

class SpecialOfferTest extends PHPUnit\Framework\TestCase
{
    private $http;
    private $token;

    public function setUp()
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => getenv('TEST_HOST')]);
    }

    public function tearDown() {
        $this->http = null;
        $this->token = null;
    }

    public function testPost_CreateSpecialOffer_SpecialOfferObject()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->http->request('POST', 'special_offers', [
            'json' => [
                'name'              => 'Special Offer Test',
                'discount'          => 10,
                'expiration_date'   => '2017-10-01'
            ],
            'headers' => $headers
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=utf-8", $contentType);
    }
}
