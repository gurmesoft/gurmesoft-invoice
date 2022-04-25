<?php

namespace GurmesoftInvoice\Base;

use Exception;

class Provider
{
    public $provider;
    public $httpOptions;
    
    public function check($requirements, $class)
    {
        foreach ($requirements as $prop) {
            if (empty($class->$prop)) {
                throw new Exception($prop. " cannot be empty.");
            }
        }
    }

    public function setHttpOptions(array $options = array())
    {
        $this->httpOptions = $options;
    }

    public function getHttpOptions()
    {
        return is_array($this->httpOptions) ? $this->httpOptions : array();
    }

    public function request(array $options, string $url = '', string $type = 'POST')
    {
        $guzzle     = new \GuzzleHttp\Client($this->getHttpOptions());
        $response   = $guzzle->request($type, $url, $options);
        return json_decode($response->getBody()->getContents());
    }
}
