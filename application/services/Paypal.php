<?php
    namespace ThinService;
    class Paypal extends \Thin\Data
    {
        public static function payment($id)
        {
            $token = \Thin\Paypal::getToken(array('environment' => 'development', 'clientId' => 'Aa3h0hD-2KxHL9a4wB8jjT16QWyjPX_m04LIwGtULnqrAYXCovC2Cpl9pJBG', 'clientSecret' => 'EMAaghBFwZKn-TksedeIhKyBfk-UmCmoc7bltPIXiwfEoerVW01CEXL-U4Ww'));
            return \Thin\Paypal::Payment(array('token' => $token, 'environment' => 'development', 'amount' => '300.00', 'currency' => 'CAD', 'returnUrl' => URLSITE . 'payment/success', 'cancelUrl' => URLSITE . 'payment/error', 'id' => $id));
            //*GP* $token = \Thin\Paypal::getToken(array('environment' => 'production', 'clientId' => 'ASlIuhBqBYJk77nd16LD7X0PrTgql4TojuIYqFOAdiFbOv1dMEvKMqdUUZy7', 'clientSecret' => 'EN0nmxDbY00GaDbWIn6jJ3AlnyK7d3548cVA7VPk14vsbyABEDrQzF7g5wZq'));
            //*GP* return \Thin\Paypal::Payment(array('token' => $token, 'environment' => 'production', 'amount' => '300.00', 'currency' => 'CAD', 'returnUrl' => URLSITE . 'payment/success', 'cancelUrl' => URLSITE . 'payment/error', 'id' => $id));
        }
    }
