<?php

namespace Omnipay\GoPay;

use Omnipay\Omnipay;
use Symfony\Component\HttpFoundation\Request;

class GatewayFactory
{
    /**
     * @param string $goId
     * @param string $clientId
     * @param string $clientSecret
     * @param bool $testMode
     * @param Request|null $httpRequest
     * @return Gateway
     */
    public static function createInstance($goId, $clientId, $clientSecret, $testMode = true, $httpRequest = null)
    {
        $gateway = Omnipay::create('GoPay', null, $httpRequest);
        $gateway->initialize([
            'goId' => $goId,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'testMode' => $testMode,
        ]);

        return $gateway;
    }
}
