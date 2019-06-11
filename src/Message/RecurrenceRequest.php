<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractRequest;

class RecurrenceRequest extends AbstractRequest
{

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->getParameter('purchaseData');
    }

    /**
     * Get the transaction reference which was used to create recurrent profile
     *
     * @return mixed
     */
    public function getTransactionReference()
    {
        return $this->getParameter('transactionReference');
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return RecurrenceResponse
     */
    public function sendData($data)
    {
        $headers = [
            'Accept' => 'application/json',
            'Accept-Language' => 'en-US',
            'Content-Type' => 'application/json',
            'Authorization' => $this->getParameter('token'),
        ];

        $transactionReference = $this->getTransactionReference();

        $httpResponse = $this->httpClient->request(
            'POST',
            $this->getParameter('apiUrl') . '/api/payments/payment/' . $transactionReference . '/create-recurrence',
            $headers,
            json_encode($data)
        );

        $purchaseResponseData = json_decode($httpResponse->getBody()->getContents(), true);

        $data = $purchaseResponseData;
        $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        $firstRun = true;
        while ($purchaseResponseData['state'] == 'CREATED') {
            $httpResponse = $this->httpClient->request(
                'GET',
                $this->getParameter('apiUrl') . '/api/payments/payment/' . $transactionReference,
                $headers
            );
            $purchaseResponseData = json_decode($httpResponse->getBody()->getContents(), true);
            if (!$firstRun) {
                sleep(2);
            }
            $firstRun = false;
        }

        $response = new RecurrenceResponse($this, $purchaseResponseData);
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
     * @param array $data
     */
    public function setPurchaseData($data)
    {
        $this->setParameter('purchaseData', $data);
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }
}
