<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest
{

    /** @var string */
    private $accessToken;

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getParameters()['purchaseData'];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return PurchaseResponse
     */
    public function sendData($data)
    {
        $headers = [
            'Accept' => 'application/json',
            'Accept-Language' => 'en-US',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->accessToken,
        ];

        $httpRequest = $this->httpClient->post(
            'https://gw.sandbox.gopay.com/api/payments/payment',
            $headers,
            json_encode($data)
        );

        $httpResponse = $httpRequest->send();
        $purchaseResponseData = $httpResponse->json();

        $response = new PurchaseResponse($this, $purchaseResponseData);
        return $response;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function setPurchaseData($data)
    {
        $this->setParameter('purchaseData', $data);
    }
}