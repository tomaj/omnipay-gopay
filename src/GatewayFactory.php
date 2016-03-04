<?php

namespace Omnipay\GoPay;

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
        $gateway = new \Omnipay\GoPay\Gateway();
        $gateway->initialize([
            'goid' => $goid,
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'isProductionMode' => !$isSandbox,
        ]);

        return $gateway;
    }
}
