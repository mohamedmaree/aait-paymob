<?php

namespace Maree\Paymob\Tests;
use Tests\TestCase;
use Maree\Paymob\Paymob;

class SampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
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
        $response = Paymob::checkout($amount_cents = 100 , $items,$billing_data ,$delivery_needed = false);
        $this->assertEquals(1, 1);

    }

    public function testResponseTest()
    {
        $response = Paymob::checkoutResponseStatus();
        $this->assertEquals(200, $response->status());      
    }

}
