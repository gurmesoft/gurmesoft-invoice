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

    public function getDocumentType($code)
    {
        $types = array(
            'Mysoft' => array(
                'EARSIVFATURA',
                'EFATURA',
                'ESMM',
                'EMM'
            )
        );

        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'EARSIVFATURA';
    }

    public function getScenario($code)
    {
        $types = array(
            'Mysoft' => array(
                'EARSIVFATURA',
                'TEMELFATURA',
                'TICARIFATURA',
                'YOLCUBERABERFATURA',
                'IHRACAT',
                'OZELFATURA',
                'KAMU',
                'HKS',
                'EARSIVBELGE'
            )
        );
        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'EARSIVFATURA';
    }

    public function getInvoiceType($code)
    {
        $types = array(
            'Mysoft' => array(
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
            )
        );
        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'SATIS';
    }

    public function getCurrencyCode($code)
    {
        $types = array(
            'Mysoft' => array(
                'TRY',
                'USD',
                'EUR',
                'GBP'
            )
        );
        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'TRY';
    }
    
    public function getCancelCode($code)
    {
        $types = array(
            'Mysoft' => array(
                'GIB',
                'NOTER',
                'KEP',
                'TAAHHUTLUMEKTUP',
                'PORTAL'
            )
        );
        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'GIB';
    }

    public function getUnitCode($code)
    {
        $types = array(
            'Mysoft' => array(
                'ADET',
                'KUTU',
                'LITRE',
                'M',
                'CM'
            )
        );
        return array_key_exists($code, $types[$this->provider]) ? $types[$code][$this->provider] : 'ADET';
    }
}
