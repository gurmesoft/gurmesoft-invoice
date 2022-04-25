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
        $this->provider = 'Mysoft';
        $this->url      = 'https://edocumentapi.mysoft.com.tr';

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
        $taxpayer   = $doc->getTaxpayer();
        $lines      = $doc->getLines();
        $invoice    = array(
            'isCalculateByApi'      => false,
            'isManuelCalculation'   => false,
            'invoiceDetail'         => array(),
            'id'                    => $doc->getId(),
            'eDocumentType'         => $doc->getDocumentType(),
            'profile'               => $doc->getScenario(),
            'senderType'            => 'ELEKTRONIK',
            'invoiceType'           => $doc->getType(),
            'prefix'                => $doc->getPrefix(),
            'docDate'               => $doc->getDate(),
            'docTime'               => $doc->getDate(),
            'currencyCode'          => $doc->getCurrency(),
            'currencyRate'          => $doc->getCurrencyRate(),
            'invoiceAccount'        => array(
                'vknTckn'               => $taxpayer->getTaxNumber(),
                'taxOfficeName'         => $taxpayer->getTaxOffice(),
                'accountName'           => $taxpayer->getCompany() ? $taxpayer->getCompany() : $taxpayer->getFirstName() .' '.$taxpayer->getLastName(),
                'countryName'           => $taxpayer->getCountry(),
                'cityName'              => $taxpayer->getCity(),
                'citySubdivision'       => $taxpayer->getDistrict(),
                'streetName'            => $taxpayer->getAddress(),
            ),
        );

        foreach ($lines as $line) {
            $invoice['invoiceDetail'][] = array(
                'unitCode'          => 'C62',
                'productCode'       => $line->getStockCode(),
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
            ->setReference($response->data->invoiceETTN)
            ->setDocumentNo($response->data->docNo);
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
                'cancelType'    => $type ? $type : 'GIB' ,
                'cancelNote'    => $message,
                'cancelDate'    => date('m/d/Y H:i:s')
            )
        );

        $response   = $this->request($options, $url, 'GET');
        $result     = new \GurmesoftInvoice\Base\Result;
        $result->setResponse($response);
        if ($response->succeed) {
            $result->setIsSuccess(true);
        } else {
            $result->setErrorCode(strval($response->errorCode))
            ->setErrorMessage($response->message);
        }

        return $result;
    }

    public function checkInvoiceStatus($referenceNo)
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

    public function getInvoicePdf($referenceNo)
    {
        $token  = $this->token();
        $url    = '/api/InvoiceOutbox/getInvoiceOutboxPdfAsZip';
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

        $putDir = dirname(__DIR__) . '/Temp';
        $fileName = $referenceNo . '.zip';
        $fullName = $putDir .'/'. $fileName;
        file_put_contents($fullName, base64_decode($response->data));
        header('Content-Type: application/zip');
        header('Content-Length: ' . filesize($fullName));
        header('Content-Disposition: attachment; filename="'.$fileName.'"');
        readfile($fullName);
        unlink($fullName);
    }
    
    public function checkTaxpayerStatus($taxNumber)
    {
        $token  = $this->token();
        $url    = '/api/GeneralCard/getGibAccountModel';
        $header = array(
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'query'         => array(
                'vknTckn'   => $taxNumber
            )
        );

        $response   = $this->request($options, $url, 'GET');
        $result     = new \GurmesoftInvoice\Base\Result;

        $result->setResponse($response);
        if ($response->data !== null) {
            $result->setIsEFatura(true);
        }

        return $result;
    }

    public function getTaxpayerList($start, $limit)
    {
        $token  = $this->token();
        $url    = '/api/GeneralCard/accountList';
        $header = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'body'          => json_encode(array(
                'afterValue'    => $start,
                'limit'         => $limit,
            ))
        );
        $response   = $this->request($options, $url);
        $result     = new \GurmesoftInvoice\Base\Result;

        $list = array();
        $result->setResponse($response);

        if ($response->data !== null) {
            foreach ($response->data as $payer) {
                $taxpayer = new \GurmesoftInvoice\Base\Taxpayer;
                $taxpayer->setTaxNumber($payer->identifierNumber)
                ->setTaxOffice($payer->taxOffice->name ? $payer->taxOffice->name : '' )
                ->setAlias($payer->accountName)
                ->setAddress($payer->streetName)
                ->setDistrict($payer->citySubdivision)
                ->setCity($payer->city->name)
                ->setCountry('Türkiye')
                ->setPhone($payer->telephone1)
                ->setEmail($payer->email1);
                
                array_push($list, $taxpayer);
            }

            $result->setIsSuccess(true)->setList($list);
        }
        
        return $result;
    }

    public function getInvoiceList($start, $end)
    {
        $token  = $this->token();
        $url    = '/api/InvoiceOutbox/getInvoiceOutboxWithHeaderInfoList';
        $header = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'body'          => json_encode(array(
                'startDate'    => $start,
                'endDate'      => $end,
                'isUseDocDate' => true,
                'limit'        => 100
            ))
        );
        $response   = $this->request($options, $url);
        $result     = new \GurmesoftInvoice\Base\Result;

        $list = array();
        $result->setResponse($response);

        if ($response->data !== null) {
            foreach ($response->data as $invoice) {
                $doc = new \GurmesoftInvoice\Base\Invoice;
                $taxpayer = new \GurmesoftInvoice\Base\Taxpayer;

                $taxpayer->setAlias($invoice->accountName)
                ->setTaxNumber($invoice->vknTckn);

                $doc->setReferenceNo($invoice->ettn)
                ->setDocumentNo($invoice->docNo)
                ->setScenario($invoice->profile)
                ->setStatus($invoice->invoiceStatusText)
                ->setType($invoice->invoiceType)
                ->setTaxpayer($taxpayer);
    
                array_push($list, $doc);
            }

            $result->setIsSuccess(true)->setList($list);
        }
        
        return $result;
    }

    public function getProduct($stockCode)
    {
        $token  = $this->token();
        $url    = '/api/GeneralCard/productList';
        $header = array(
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => "Bearer {$token}"
        );
        $options = array(
            'headers'       => $header,
            'body'          => json_encode(array(
                'productCode'   => $stockCode,
            ))
        );

        $response   = $this->request($options, $url);
        $result     = new \GurmesoftInvoice\Base\Result;

        $result->setResponse($response);
        if ($response->data !== null) {
            $result->setProduct($response->data[0]);
        }

        return $result;
    }
}
