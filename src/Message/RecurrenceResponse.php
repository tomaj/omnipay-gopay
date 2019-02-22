<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class RecurrenceResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return in_array($this->getCode(), ['CREATED']);
    }

    public function isRedirect()
    {
    	return false;
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
        if (isset($this->data['id']) && !empty(isset($this->data['id']))) {
            return (string) $this->data['id'];
        }
        return null;
    }

    public function getTransactionId()
    {
        if (isset($this->data['order_number']) && !empty($this->data['order_number'])) {
            return (string) $this->data['order_number'];
        }
        return null;
    }

    public function getParentId()
    {
        if (isset($this->data['parent_id']) && !empty($this->data['parent_id'])) {
            return (string) $this->data['parent_id'];
        }
        return null;
    }
}