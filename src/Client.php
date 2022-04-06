<?php

namespace GurmesoftInvoice;

use Exception;

class Client
{
    public function __construct($provider, $options)
    {
        $class = "\\GurmesoftInvoice\\Providers\\$provider";
        $this->class = new $class($options);
    }

    public function sendInvoice(\GurmesoftInvoice\Invoice $document)
    {
        return $this->class->sendInvoice($document);
    }
}
