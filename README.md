# Voucher Pool API

This API (powered by [Slim](https://www.slimframework.com/)) generates voucher codes for special offers. 

## Installation
1. Clone this repository.
2. Run composer install.
3. Env file:

```
* Copy file .env.example to .env
```

4. Docker up: 

```
docker-compose up -d
```

5. Run migrations:
```
vendor/bin/phinx migrate
```
If it fails, use database.sql file to create database structure.

## Usage

* Create Special Offer and generate voucher codes for all recipients

```
POST http://localhost:8080/special_offers

Payload:

{
	"name": "Black Tuesday Discount",
	"discount": 20,
	"expiration_date": "2018-10-15"
}
```

* Validate voucher code

```
POST http://localhost:8080/validate_voucher_code

Payload:

{
	"voucher_code": "9045EB89B5",
	"email": "test@test.com"
}
```

* Get valid voucher codes

```
GET http://localhost:8080/voucher_codes?email=test@test.com

Example Response:

[
    {
        "name": "Black Monday Discount",
        "discount": 40,
        "code": "3046C776F3"
    },
    {
        "name": "Summer Special Offer",
        "discount": 15,
        "code": "AC292BE1E3"
    },
    {
        "name": "Blue Monday Discount",
        "discount": 15,
        "code": "780DA9833B"
    }
]
```

## Tests

- Run PHPUnit Tests with:

```
./vendor/bin/phpunit ./tests
```
