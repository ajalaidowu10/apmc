<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RazorpayApiAuthController extends Controller
{
    public $client;
    function __construct()
    {
      $this->client = new Client([
        'defaults' => ['exceptions' => false],
      ]);
    }

    public function order(int $id, float $amount)
    {
      $receipt  = 'booking_id_'.$id;      
      $amount   = $amount * 100;
      try {
            $response = $this->client->request('POST', 'https://api.razorpay.com/v1/orders', [
                                                'auth' => [env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET')],
                                                'json' => [
                                                            'receipt'         => $receipt,
                                                            'amount'          => $amount, 
                                                            'currency'        => 'INR',
                                                          ],
                                              ]);
            $response_body = $response->getBody();
            $response_body = json_decode($response_body);

      } catch (Exception $e) {
        
        return $e;
      }

      return ['id'=> $id, 'razorpay_order_id' => $response_body->id];
    }


}
