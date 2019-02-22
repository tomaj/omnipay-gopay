<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class CancelRecurrenceResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->getResult() == 'FINISHED';
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

    public function getId()
    {
        if (isset($this->data['id']) && !empty(isset($this->data['id']))) {
            return (string) $this->data['id'];
        }
        return null;
    }

    public function getResult()
    {
        if (isset($this->data['result']) && !empty($this->data['result'])) {
            return (string) $this->data['result'];
        }
        return null;
    }
}