# Paymob
## Installation

You can install the package via [Composer](https://getcomposer.org).

```bash
composer require maree/paymob
```
Publish your paymob config file with

```bash
php artisan vendor:publish --provider="maree\Paymob\PaymobServiceProvider" --tag="paymob"
```
then change your paymob config from config/paymob.php file
```php
    "mode"                => "test",//live
    "API_KEY"             => "" ,
    "IFRAME_ID"           => "" ,
    "INTEGRATION_ID_TEST" => "",
    "INTEGRATION_ID_LIVE" => "",
```
## Usage

- with [ visa - master - mada ]
```php
use Maree\Paymob\Paymob;
    $items = [
          [
            'name'         => 'pen',
            'amount_cents' => 10,
            'description'  => "Pen Invoice",
            'quantity'     => 1,
          ],
        ];

    $billing_data  = [
                "first_name"      => 'mohamed',
                "phone_number"    => '01002700084',
                "email"           => 'm7mdmaree26@gmail.com',
                "last_name"       => 'maree',
                "apartment"       => "10",
                "floor"           => "2",
                "street"          => "25 elrahman",
                "building"        => "40",
                "shipping_method" => "NA",
                "postal_code"     => "21532",
                "city"            => "Alexandria",
                "country"         => "EG",
                "state"           => "elnzha",
            ] ; 
Paymob::checkout($amount_cents = 100 , $items,$billing_data ,$delivery_needed = false)  

```


## note 
- define (callback) the checkout return response url route EX : https://mysite.com/paymentresponse
- create route for response url 'paymentresponse' 
EX: Route::get('paymentresponse', 'PaymentsController@paymentresponse')->name('paymentresponse'); 
- create function for checkout response 'paymentresponse'
- use that function to check if payment failed or success

## inside 'paymentresponse' function use:
```php
use Maree\Paymob\Paymob;
$response = Paymob::checkoutResponseStatus();  

```
return response like: 
```php

 ['key' => 'success' ,'msg' => 'checkout success' ,'result' => $payment_data ] 

```
or 

```php

 ['key' => 'fail' , 'msg' => 'checkout failed','result' => $payment_data]

```
note: you can use response from data to save transactions in database - 'data' key contain params like 'amount' and transaction id  

- Test Card Details
- Card Number: 2223000000000007
- CVV: 100
- Expiry Date: 01/39
- Card Name: Test Family
- Custom ECI: Leave Blank
- Custom CAVV: Leave Blank

## documentaion files.
- https://docs.paymob.com/docs/accept-standard-redirect
- https://docs.paymob.com/docs/card-payments









