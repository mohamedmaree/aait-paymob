<?php

return [


    /*
    |--------------------------------------------------------------------------
    | Merchant account authorization info
    |--------------------------------------------------------------------------
    |
    |
    */

    "API_KEY"      => "" ,
    "IFRAME_ID"    => "" ,

    /*
    |--------------------------------------------------------------------------
    | Paymob Mode
    |--------------------------------------------------------------------------
    |
    | Mode only values: "test" or "live"
    |
    */

    "mode"     => "test",

    /*
    |--------------------------------------------------------------------------
    | Paymob currency
    |--------------------------------------------------------------------------
    | EGP , SAR , USD, .. etc
    */

    "currency" => "EGP" ,

    /*
    |--------------------------------------------------------------------------
    | Payment Request url
    |--------------------------------------------------------------------------
    */

    "login_url"    => "https://accept.paymob.com/api/auth/tokens",
    "request_url"  => "https://accept.paymob.com/api/ecommerce/orders",
    "payment_url"  => "https://accept.paymob.com/api/acceptance/payment_keys",
    "redirect_url" => "https://accept.paymob.com/api/acceptance/iframes",
    
    /*
    |--------------------------------------------------------------------------
    | Integration ids
    |--------------------------------------------------------------------------
    */

    "INTEGRATION_ID_TEST" => "",
    "INTEGRATION_ID_LIVE" => "",

    
    /*
    |--------------------------------------------------------------------------
    | Payment Expire Period
    |--------------------------------------------------------------------------
    */

    "EXPIRATION"      => 3600,


];