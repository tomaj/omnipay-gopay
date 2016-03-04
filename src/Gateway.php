<?php

namespace Omnipay\GoPay;

use Omnipay\Common\AbstractGateway;
use Omnipay\GoPay\Message\AccessTokenRequest;
use Omnipay\GoPay\Message\AccessTokenResponse;
use Omnipay\GoPay\Message\PurchaseRequest;
use Omnipay\GoPay\Message\PurchaseResponse;

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

    /** @var string */
    private $goid;

    /** @var string */
    private $clientId;

    /** @var string */
    private $clientSecret;

    /** @var bool */
    private $isProductionMode;

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
            'isProductionMode' => false,
        ];
    }

    /**
     * Initialize gateway with parameters
     */
    public function initialize(array $parameters = [])
    {
        if (isset($parameters['goid'])) $this->goid = $parameters['goid'];
        if (isset($parameters['clientId'])) $this->clientId = $parameters['clientId'];
        if (isset($parameters['clientSecret'])) $this->clientSecret = $parameters['clientSecret'];
        if (isset($parameters['isProductionMode'])) $this->isProductionMode = $parameters['isProductionMode'];
    }

    /**
     * Get all gateway parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return [
            'goid' => $this->goid,
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'isProductionMode' => $this->isProductionMode,
        ];
    }

    /**
     * @return AccessTokenResponse
     */
    public function getAccessToken()
    {
        /** @var AccessTokenRequest $request */
        $request = parent::createRequest(AccessTokenRequest::class, [
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        ]);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $options
     * @return PurchaseResponse
     */
    public function purchase(array $options = [])
    {
        $accessTokenResponse = $this->getAccessToken();
        $request = parent::createRequest(PurchaseRequest::class, [
            'accessToken' => $accessTokenResponse->getAccessToken(),
            'purchaseData' => $options,
        ]);
        $response = $request->send();
        return $response;
    }
}