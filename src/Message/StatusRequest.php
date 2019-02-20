<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class StatusRequest extends AbstractRequest
{

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

        $httpResponse = $this->httpClient->request(
            'GET',
            $this->getParameter('apiUrl') . '/api/payments/payment/' . $this->getParameter('transactionReference'),
            $headers
        );

        $statusResponseData = json_decode($httpResponse->getBody()->getContents(), true);

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
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return [];
    }
}
