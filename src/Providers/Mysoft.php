<?php

namespace GurmesoftInvoice\Providers;

class Mysoft extends \GurmesoftInvoice\Providers\BaseProvider
{
    public function __construct(array $options)
    {
        $this->prepare($options);
    }

    private function prepare($options)
    {
        $this->url = 'https://edocumentapi.mysoft.com.tr';

        if (isset($options['live']) && $options['live'] === false) {
            $this->url = 'https://edocumentapitest.mysoft.com.tr ';
        }

        if (isset($options['apiKey']) && !empty($options['apiKey'])) {
            $this->apiKey = $options['apiKey'];
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
