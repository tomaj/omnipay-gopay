<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $redirectUrl = $this->getRedirectUrl();
        return is_string($redirectUrl);
    }

    /**
     * Gets the redirect target url.
     */
    public function getRedirectUrl()
    {
        if (!is_array($this->data) || !isset($this->data['gw_url']) || !is_string($this->data['gw_url'])) {
            return null;
        }
        return $this->data['gw_url'];
    }

    /**
     * Get the required redirect method (either GET or POST).
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getRedirectData()
    {
        return null;
    }

    public function getCode()
    {
        if (isset($this->data['state'])) {
            return $this->data['state'];
        }
        return null;
    }

    public function getTransactionReference()
    {
        if (isset($this->data['id'])) {
            return $this->data['id'];
        }
        return null;
    }

    public function getTransactionId()
    {
        if (isset($this->data['order_number'])) {
            return $this->data['order_number'];
        }
        return null;
    }

}