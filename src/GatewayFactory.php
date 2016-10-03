<?php

namespace Omnipay\GoPay;

use Omnipay\Omnipay;

class GatewayFactory
{
    /**
     * @param string $goid
     * @param string $clientId
     * @param string $clientSecret
     * @param bool $isSandbox
     * @return Gateway
     */
    public static function createInstance($goid, $clientId, $clientSecret, $isSandbox = true)
    {
        $gateway = Omnipay::create('gopay');
        $gateway->initialize([
            'goid' => $goid,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'testMode' => $isSandbox,
        ]);

        return $gateway;
    }
}
