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
        return is_array($this->data)
            && isset($this->data['access_token']) && is_string($this->data['access_token'])
            && isset($this->data['token_type']) && is_string($this->data['token_type']);
    }

    /**
     * @return string
     */
    public function getToken()
    {
        $completeToken = sprintf('%s %s', ucfirst($this->data['token_type']), $this->data['access_token']);

        return $completeToken;
    }

}