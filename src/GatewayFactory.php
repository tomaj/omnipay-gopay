<?php

namespace Omnipay\GoPay;

use Omnipay\Omnipay;

class GatewayFactory
{
    /**
     * @param string $goId
     * @param string $clientId
     * @param string $clientSecret
     * @param bool $testMode
     * @return Gateway
     */
    public static function createInstance($goId, $clientId, $clientSecret, $testMode = true)
    {
        $gateway = Omnipay::create('GoPay');
        $gateway->initialize([
            'goId' => $goId,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'testMode' => $testMode,
        ]);

        return $gateway;
    }
}
