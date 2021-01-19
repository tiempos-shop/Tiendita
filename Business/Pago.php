<?php


namespace Tiendita;

require_once("Conekta.php");
class Pago
{
    public function __construct()
    {


        Conekta::setApiKey("key_eYvWV7gSDkNYXsmr");
        Conekta::setApiVersion("2.0.0");
        Conekta::setLocale('es');

        // Ejemplo Orden



    }



    public function Order(){
        Order::create
        ([
            'currency' => 'MXN',
            'customer_info' => [
                'customer_id' => 'cus_zzmjKsnM9oacyCwV3',
                'antifraud_info' => [
                    'paid_transactions' => 4
                ]
            ],
            'line_items' => [
            [
                'name' => 'Box of Cohiba S1s',
                'unit_price' => 35000,
                'quantity' => 1,
                'antifraud_info' => [
                    'trip_id'        => '12345',
                    'driver_id'      => 'driv_1231',
                    'ticket_class'   => 'economic',
                    'pickup_latlon'  => '23.4323456,-123.1234567',
                    'dropoff_latlon' => '23.4323456,-123.1234567'
                ]
            ]
        ],
        'charges' => [
            [
                'payment_method' => [
                    'type' => 'default'
                ]
            ]
        ]
        ]);
    }
}