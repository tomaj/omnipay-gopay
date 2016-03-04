<?php

namespace Omnipay\GoPay\Message;

use Omnipay\Common\Message\AbstractResponse;

class AccessTokenResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        return is_array($this->data) && isset($this->data['access_token']) && is_string($this->data['access_token']);
    }

    public function getAccessToken()
    {
        if (!isset($this->data['access_token'])) {
            return;
        }
        return $this->data['access_token'];
    }

}