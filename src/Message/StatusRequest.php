<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class StatusRequest extends AbstractRequest
{

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
            'Authorization' => $this->getParameter('token'),
        ];

        $httpRequest = $this->httpClient->get(
            $this->getParameter('apiUrl') . '/api/payments/payment/' . $data['paymentId'],
            $headers
        );

        $httpResponse = $httpRequest->send();
        $statusResponseData = $httpResponse->json();
        $response = new PurchaseResponse($this, $statusResponseData);
        return $response;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->setParameter('token', $token);
    }

    /**
     * @param string $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->setParameter('paymentId', $paymentId);
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }

}
