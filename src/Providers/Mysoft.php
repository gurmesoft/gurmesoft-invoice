<?php

namespace GurmesoftInvoice\Providers;

class Mysoft extends \GurmesoftInvoice\Base\Provider
{
    public function __construct(array $options)
    {
        $this->prepare($options);

        $requirements = array(
            'apiUser',
            'apiPass'
        );
        
        $this->check($requirements, $this);
    }

    private function prepare($options)
    {
        $this->url = 'https://edocumentapi.mysoft.com.tr';

        if (isset($options['live']) && $options['live'] === false) {
            $this->url = 'https://edocumentapitest.mysoft.com.tr ';
        }

        if (isset($options['apiUser']) && !empty($options['apiUser'])) {
            $this->apiKey = $options['apiUser'];
        }

        if (isset($options['apiPass']) && !empty($options['apiPass'])) {
            $this->apiPass = $options['apiPass'];
        }
    }

    public function sendInvoice($document)
    {
        var_dump($document);
    }
}
