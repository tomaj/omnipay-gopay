<?php

namespace Omnipay\GoPay\Message;

use Guzzle\Http\Client;
use Guzzle\Http\ClientInterface;
use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\NotificationInterface;
use Symfony\Component\HttpFoundation\Request;

class Notification implements NotificationInterface
{

    /** @var Request */
    private $httpRequest;

    /** @var Client|ClientInterface */
    private $httpClient;

    /**
     * @var array
     */
    private $parameters;

    public function __construct($httpRequest, $httpClient, $parameters)
    {
        $this->httpRequest = $httpRequest;
        $this->httpClient = $httpClient;
        $this->parameters = $parameters;
    }

    /**
     * Gateway Reference
     *
     * @return string A reference provided by the gateway to represent this transaction
     */
    public function getTransactionReference()
    {
        if (isset($this->getData()['id'])) {
            return $this->getData()['id'];
        }

        return null;
    }

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     * @return array
     * @throws InvalidRequestException
     */
    public function getData()
    {
        return $this->parameters;
    }

    /**
     * Was the transaction successful?
     *
     * @return string Transaction status, one of {@see STATUS_COMPLETED}, {@see #STATUS_PENDING} or {@see #STATUS_FAILED}.
     * @throws InvalidRequestException
     */
    public function getTransactionStatus()
    {
        if ($this->getData()) {
            $status = $this->getData()['code'];
            if (in_array($status, ['PAID'], true)) {
                return self::STATUS_COMPLETED;
            } elseif (in_array($status, ['AUTHORIZED', 'PAYMENT_METHOD_CHOSEN', 'CREATED'], true)) {
                return self::STATUS_PENDING;
            } elseif (in_array($status, ['CANCELED', 'TIMEOUTED'], true)) {
                return self::STATUS_FAILED;
            }
            throw new InvalidRequestException('We have received unknown status "' . $status . '"');
        }
    }

    /**
     * Response Message
     *
     * @return string A response message from the payment gateway
     */
    public function getMessage()
    {
        return null;
    }
}
