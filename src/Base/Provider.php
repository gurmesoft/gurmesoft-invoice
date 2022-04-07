<?php

namespace GurmesoftInvoice\Base;

use Exception;

class Provider
{
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

    public function getDocumentType($code)
    {
        $types = array(
            'EARSIVFATURA',
            'EFATURA',
            'ESMM',
            'EMM'
        );
        return array_key_exists($code, $types) ? $types[$code] : 'EARSIVFATURA';
    }

    public function getScenario($code)
    {
        $types = array(
            'EARSIVFATURA',
            'TEMELFATURA',
            'TICARIFATURA',
            'YOLCUBERABERFATURA',
            'IHRACAT',
            'OZELFATURA',
            'KAMU',
            'HKS',
            'EARSIVBELGE'
        );
        return array_key_exists($code, $types) ? $types[$code] : 'EARSIVFATURA';
    }

    public function getInvoiceType($code)
    {
        $types = array(
            'SATIS',
            'IADE',
            'TEVKIFAT',
            'ISTISNA',
            'OZELMATRAH',
            'IHRACKAYITLI',
            'SGK',
            'KOMISYONCU',
            'HKSSATIS',
            'HKSKOMISYONCU'
        );
        return array_key_exists($code, $types) ? $types[$code] : 'SATIS';
    }

    public function getCurrencyCode($code)
    {
        $types = array(
            'TRY',
            'USD',
            'EUR',
            'GBP'
        );
        return array_key_exists($code, $types) ? $types[$code] : 'TRY';
    }
}
