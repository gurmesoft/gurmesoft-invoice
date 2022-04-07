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
            $this->url = 'https://edocumentapitest.mysoft.com.tr';
        }

        if (isset($options['apiUser']) && !empty($options['apiUser'])) {
            $this->apiUser = $options['apiUser'];
        }

        if (isset($options['apiPass']) && !empty($options['apiPass'])) {
            $this->apiPass = $options['apiPass'];
        }

        $options = array('base_uri' => $this->url);
        $this->setHttpOptions($options);
    }

    public function token()
    {
        $url    = '/oauth/token';
        $header = array(
            'Content-Type'  => 'application/x-www-form-urlencoded',
            'Accept'        => 'application/json'
        );
        $body   = array(
            'username'      => $this->apiUser,
            'password'      => $this->apiPass,
            'grant_type'    => 'password'
        );
        $options = array(
            'form_params'   => $body,
            'headers'       => $header
        );

        $response = $this->request($options, $url);
        return $response->access_token;
    }

    public function sendInvoice($doc)
    {
        $token      = $this->token();
        $customer   = $doc->getCustomer();
        $lines      = $doc->getLines();
        $invoice    = array(
            'isCalculateByApi'      => false,
            'isManuelCalculation'   => false,
            'invoiceDetail'         => array(),
            'id'                    => $doc->getId(),
            'eDocumentType'         => $this->getDocumentType($doc->getDocumentType()),
            'profile'               => $this->getScenario($doc->getScenario()),
            'invoiceType'           => $this->getInvoiceType($doc->getType()),
            'prefix'                => $doc->getPrefix(),
            'docDate'               => $doc->getDate(),
            'docTime'               => $doc->getDate(),
            'currencyCode'          => $this->getCurrencyCode($doc->getCurrency()),
            'currencyRate'          => $doc->getCurrencyRate() ? $doc->getCurrencyRate() : '1',
            'invoiceAccount'        => array(
                'vknTckn'               => $customer->getTaxNumber(),
                'taxOfficeName'         => $customer->getTaxOffice(),
                'accountName'           => $customer->getCompany() ? $customer->getCompany() : $customer->getFirstName() .' '.$customer->getLastName(),
                'countryName'           => $customer->getCountry(),
                'cityName'              => $customer->getCity(),
                'citySubdivision'       => $customer->getDistrict(),
                'streetName'            => $customer->getAddress(),
            ),
        );

        foreach ($lines as $line) {
            $invoice['invoiceDetail'][] = array(
                'productCode'       => $line->getStockCode(),
                'unitCode'          => $line->getUnitCode(),
                'productName'       => $line->getName(),
                'qty'               => $line->getQuantity(),
                'unitPriceTra'      => $line->getUnitPrice(),
                'vatRate'           => $line->getVatRate(),
                'amtVatTra'         => $line->getVatTotal(),
                'amtTra'            => $line->getTotal()
            );
        }

        $url    = '/api/InvoiceOutbox/invoiceOutbox';
        $header = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'body'          => json_encode($invoice)
        );

        $response   = $this->request($options, $url);
        $result     = new \GurmesoftInvoice\Base\Result;
        $result->setResponse($response);
        if ($response->succeed) {
            $result->setIsSuccess(true)
            ->setReference($response->data->invoiceETTN);
        } else {
            $result->setErrorCode(strval($response->errorCode))
            ->setErrorMessage($response->message);
        }

        return $result;
    }

    public function checkStatus($referenceNo)
    {
        $token  = $this->token();
        $url    = '/api/InvoiceOutbox/getInvoiceOutboxStatus';
        $header = array(
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'query'         => array(
                'invoiceETTN'   => $referenceNo
            )
        );

        $response   = $this->request($options, $url, 'GET');
        $result     = new \GurmesoftInvoice\Base\Result;
        $result->setResponse($response);
        if ($response->succeed) {
            $result->setIsSuccess(true)
            ->setReference($response->data->invoiceETTN)
            ->setStatus($response->data->invoiceStatusText);
        } else {
            $result->setErrorCode(strval($response->errorCode))
            ->setErrorMessage($response->message);
        }

        return $result;
    }

    public function cancelInvoice($referenceNo, $message, $type)
    {
        date_default_timezone_set('Europe/Istanbul');
        $token  = $this->token();
        $url    = '/api/InvoiceOutbox/cancelEArchiveInvoice';
        $header = array(
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'query'         => array(
                'invoiceETTN'   => $referenceNo,
                'cancelType'    => $this->getCancelCode($type),
                'cancelNote'    => $message,
                'cancelDate'    => date('m/d/Y H:i:s')
            )
        );

        $response   = $this->request($options, $url, 'GET');
        var_dump($response);
    }
}
