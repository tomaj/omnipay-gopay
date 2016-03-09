<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class StatusRequest extends AbstractRequest
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
        return [
            'paymentId' => $this->getParameters()['paymentId'],
        ];
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
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Bearer ' . $this->accessToken,
        ];

        $httpRequest = $this->httpClient->get(
            'https://gw.sandbox.gopay.com/api/payments/payment/' . $data['paymentId'],
            $headers
        );

        $httpResponse = $httpRequest->send();
        $statusResponseData = $httpResponse->json();
        $response = new PurchaseResponse($this, $statusResponseData);
        return $response;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->setParameter('paymentId', $paymentId);
    }
}