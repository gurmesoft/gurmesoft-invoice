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
        $this->empty($provider, 'provider');
        $class = "\\GurmesoftInvoice\\Providers\\$provider";
        $this->class = new $class($options);
    }

    public function sendInvoice(\GurmesoftInvoice\Base\Invoice $document)
    {
        return $this->class->sendInvoice($document);
    }

    public function cancelInvoice($referenceNo, $message = 'İptal Edildi', $type = '0')
    {
        $this->empty($referenceNo, 'reference number');

        return $this->class->cancelInvoice($referenceNo, $message, $type);
    }

    public function checkInvoiceStatus($referenceNo)
    {
        $this->empty($referenceNo, 'reference number');
        return $this->class->checkStatus($referenceNo);
    }

    public function checkTaxpayerStatus($taxNumber)
    {
        $this->empty($taxNumber, 'tax number');
        return $this->class->checkTaxpayerStatus($taxNumber);
    }

    public function getTaxpayerList($start = 0, $limit = 100)
    {
        return $this->class->getTaxpayerList($start, $limit);
    }

    public function getProduct($stockCode)
    {
        $this->empty($stockCode, 'product stock code');
        return $this->class->getProduct($stockCode);
    }

    private function empty($param, $message)
    {
        if (empty($param)) {
            throw new Exception(__CLASS__ . " exception $message cannot be empty.");
        }
    }
}
