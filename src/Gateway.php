<?php

namespace Omnipay\GoPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\GoPay\Message\AccessTokenRequest;
use Omnipay\GoPay\Message\AccessTokenResponse;
use Omnipay\GoPay\Message\PurchaseRequest;
use Omnipay\GoPay\Message\PurchaseResponse;
use Omnipay\GoPay\Message\StatusRequest;

/**
 * GoPay payment gateway
 *
 * @package Omnipay\GoPay
 * @see https://doc.gopay.com/en/
 */
class Gateway extends AbstractGateway
{

    const URL_SANDBOX = 'https://gw.sandbox.gopay.com';
    const URL_PRODUCTION = 'https://gate.gopay.cz';

    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'GoPay';
    }

    /**
     * Get gateway short name
     *
     * This name can be used with GatewayFactory as an alias of the gateway class,
     * to create new instances of this gateway.
     */
    public function getShortName()
    {
        return 'gopay';
    }

    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     *     'landingPage' => array('billing', 'login'), // enum variable, first item is default
     * );
     */
    public function getDefaultParameters()
    {
        return [
            'goid' => '',
            'clientId' => '',
            'clientSecret' => '',
            'testMode' => true,
        ];
    }

    /**
     * Initialize gateway with parameters
     */
    public function initialize(array $parameters = [])
    {
        parent::initialize($parameters);
        $this->setApiUrl();
        return $this;
    }

    /**
     * @return AccessTokenResponse
     */
    public function getAccessToken()
    {
        /** @var AccessTokenRequest $request */
        $request = parent::createRequest(AccessTokenRequest::class, $this->getParameters());
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $options
     * @return PurchaseResponse
     */
    public function purchase(array $options = [])
    {
        $this->setAccessToken($this->getAccessToken()->getAccessToken());
        $request = parent::createRequest(PurchaseRequest::class, $options);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $parameters
     * @return PurchaseResponse
     */
    public function completePurchase(array $parameters = [])
    {
        $this->setAccessToken($this->getAccessToken()->getAccessToken());
        $request = parent::createRequest(StatusRequest::class, $parameters);
        $response = $request->send();
        return $response;
    }

    /**
     * @return string
     */
    private function getApiUrl()
    {
        if ($this->getTestMode()) {
            return self::URL_PRODUCTION;
        } else {
            return self::URL_SANDBOX;
        }
    }

    public function setGoid($goid)
    {
        $this->setParameter('goid', $goid);
    }

    public function setClientId($clientId)
    {
        $this->setParameter('clientId', $clientId);
    }

    public function setClientSecret($clientSecret)
    {
        $this->setParameter('clientSecret', $clientSecret);
    }

    public function setApiUrl()
    {
        $this->setParameter('apiUrl', $this->getApiUrl());
    }

    private function setAccessToken($accessToken)
    {
        $this->setParameter('accessToken', $accessToken);
    }

}