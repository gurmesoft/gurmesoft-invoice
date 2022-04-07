<?php

namespace GurmesoftInvoice;

use Exception;

class Client
{
    /**
     * @param string $provider
     * @param array  $options
     */
    public function __construct($provider, $options)
    {
        $this->empty($provider);
        $class = "\\GurmesoftInvoice\\Providers\\$provider";
        $this->class = new $class($options);
    }

    public function sendInvoice(\GurmesoftInvoice\Base\Invoice $document)
    {
        return $this->class->sendInvoice($document);
    }

    public function cancelInvoice($referenceNo, $message = 'İptal Edildi', $type = '0')
    {
        return $this->class->cancelInvoice($referenceNo, $message, $type);
    }

    public function checkStatus($referenceNo)
    {
        return $this->class->checkStatus($referenceNo);
    }

    private function empty($param)
    {
        if (empty($param)) {
            throw new Exception(__CLASS__ . " exception provider cannot be empty.");
        }
    }
}
