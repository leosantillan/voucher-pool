<?php

use PHPUnit\Framework\TestCase;

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

class VoucherCodeTest extends PHPUnit\Framework\TestCase
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

    public function testPost_ValidateVoucherCode_VoucherCodeObject()
    {
        $headers = [
            'Accept' => 'application/json'
        ];

        $response = $this->http->request('POST', 'validate_voucher_code', [
            'json' => [
                'voucher_code'  => 'B0CAD4AFE9',
                'email'         => 'test@test.com'
            ],
            'headers' => $headers
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=utf-8", $contentType);

        $data = json_decode($response->getBody(), true);

        if (isset($data['error'])) {
            $this->assertEquals('Voucher Code not valid', $data['error']);
        } else {
            $this->assertArrayHasKey('voucher_code', $data);
            $this->assertArrayHasKey('discount', $data);
        }
    }

    public function testGet_GetValidVoucherCode_VoucherCodeObject()
    {
        $response = $this->http->request('GET', 'voucher_codes?email=test@test.com');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=utf-8", $contentType);

        $data = json_decode($response->getBody(), true);

        if (isset($data['error'])) {
            $this->assertEquals('Email does not have valid Voucher Codes', $data['error']);
        } else {
            $elem = reset($data);

            $this->assertArrayHasKey('name', $elem);
            $this->assertArrayHasKey('discount', $elem);
            $this->assertArrayHasKey('code', $elem);
        }
    }

    public function testGet_GetValidVoucherCodeNoEmail_VoucherCodeObject()
    {
        $response = $this->http->request('GET', 'voucher_codes?email=');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json;charset=utf-8", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertEquals('Email param is required', $data['error']);
    }
}
