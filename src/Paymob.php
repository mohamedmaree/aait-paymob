<?php
namespace Maree\Paymob;

class Paymob {

    /**
     * docs https://docs.paymob.com/docs/accept-standard-redirect
     * Payment API Flow
     * 1. Authentication Request
     * 2. Order Registration API
     * 3. Payment Key Request
     * 4. https://docs.paymob.com/docs/card-payments
     * Transaction Response Callback - add route to paymob account
     * Add subscription details after payment is succesful
     */
    //$items = [
        //   [
        //     'name'         => 'pen',
        //     'amount_cents' => 10,
        //     'description'  => "Pen Invoice",
        //     'quantity'     => 1,
        //   ],
        // ];

    // 'billing_data'  => [
    //             "first_name"      => mohamed,
    //             "phone_number"    => '0000000000',
    //             "email"           => 'm7mdmaree26@gmail.com',
    //             "last_name"       => 'maree',
    //             "apartment"       => "NA",
    //             "floor"           => "NA",
    //             "street"          => "NA",
    //             "building"        => "NA",
    //             "shipping_method" => "NA",
    //             "postal_code"     => "NA",
    //             "city"            => "NA",
    //             "country"         => "NA",
    //             "state"           => "NA",
    //         ]  

    public static function checkout($amount_cents = 100 , $items = [],$billing_data = [] ,$delivery_needed = false) 
    {
        $currency      = config('paymob.currency');
        $apiKey        = config('paymob.API_KEY');
        $iframeId      = config('paymob.IFRAME_ID') ; // from account
        $integrationId = (config('paymob.mode') == 'live') ? config('paymob.INTEGRATION_ID_LIVE') : config('paymob.INTEGRATION_ID_TEST'); // from account page https://accept.paymob.com/portal2/en/PaymentIntegrations
        $expiration    = config('paymob.EXPIRATION'); // in seconds

        $client = new \GuzzleHttp\Client();
        # 1- login and create token
        $step1EndPoint = config('paymob.login_url');
        $response      = $client->post($step1EndPoint, [
          \GuzzleHttp\RequestOptions::JSON => ['api_key' => $apiKey],
        ]);
        $resArr = json_decode($response->getBody(), true);
        $token  = $resArr['token'];
        # 2- send items 
        $step2EndPoint    = config('paymob.request_url');
        $orderRegisterRes = $client->post($step2EndPoint, [
          \GuzzleHttp\RequestOptions::JSON => [
            'auth_token'      => $token,
            'delivery_needed' => $delivery_needed,
            'amount_cents'    => $amount_cents,
            'currency'        => $currency,
            'items'           => $items,
          ],
        ]);
        $orderRegisterResArr = json_decode($orderRegisterRes->getBody(), true);
        $id                  = (string) $orderRegisterResArr['id'];

        # 3- send billing_data
        $step3EndPoint = config('paymob.payment_url');
        $paymentKeyRes = $client->post($step3EndPoint, [
          \GuzzleHttp\RequestOptions::JSON => [
            'auth_token'           => $token,
            'amount_cents'         => $amount_cents,
            'expiration'           => $expiration,
            'order_id'             => $id,
            'currency'             => $currency,
            'integration_id'       => $integrationId,
            'lock_order_when_paid' => "true",
            /**
             * The billing data related to the customer related to this payment.
             * All the fields in this object are mandatory,
             * you can send any of these information if it isn't available,
             * please send it to be "NA",
             * except, first_name, last_name, email, and phone_number cannot be sent as "NA".
             */
            'billing_data'  => $billing_data,
          ],
        ]);

        $paymentKeyResArr = json_decode($paymentKeyRes->getBody(), true);
        $paymentToken     = $paymentKeyResArr['token'];
        
        $redirect_url  = config('paymob.redirect_url');
        $redirect_url .= '/'.$iframeId.'?payment_token='.$paymentToken;
        # 4 - redirect to payment page
        return redirect()->to($redirect_url)->send();
        // return redirect($redirect_url);
    }

  /**
   * Obtain Paymob payment information
   * @return void
   */
    public static function checkoutResponseStatus(){
        $payment    = Request()->all();
        if (isset($payment['success']) && $payment['success'] == "false") {
            return ['key' => 'fail' , 'msg' => 'checkout failed','result' => $payment];
        }
        return ['key' => 'success' ,'msg' => 'checkout success' ,'result' => $payment ];
    }
   
}