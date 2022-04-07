<?php

namespace GurmesoftInvoice\Base;

class Invoice
{
    protected $lines;
    protected $customer;
    protected $id;
    protected $type;
    protected $scenario;
    protected $documentType;
    protected $prefix;
    protected $date;
    protected $dueDate;
    protected $currency;
    protected $currencyRate;
    protected $referenceNo;
    protected $subTotal;
    protected $vatTotal;
    protected $total;

    public function addLine(\GurmesoftInvoice\Base\Line $item)
    {
        $this->lines[] = $item;
        return $this;
    }

    public function setCustomer(\GurmesoftInvoice\Base\Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function setId(string $param)
    {
        $this->id = $param;
        return $this;
    }

    public function setType(string $param)
    {
        $this->type = $param;
        return $this;
    }

    public function setScenario(string $param)
    {
        $this->scenario = $param;
        return $this;
    }

    public function setDocumentType(string $param)
    {
        $this->documentType = $param;
        return $this;
    }

    public function setPrefix(string $param)
    {
        $this->prefix = $param;
        return $this;
    }

    public function setDate(string $param)
    {
        $this->date = $param;
        return $this;
    }

    public function setDueDate(string $param)
    {
        $this->dueDate = $param;
        return $this;
    }

    public function setCurrency(string $param)
    {
        $this->currency = $param;
        return $this;
    }

    public function setCurrencyRate(string $param)
    {
        $this->currencyRate = $param;
        return $this;
    }

    public function setReferenceNo(string $param)
    {
        $this->referenceNo = $param;
        return $this;
    }

    public function setSubTotal(string $param)
    {
        $this->subTotal = $param;
        return $this;
    }

    public function setVatTotal(string $param)
    {
        $this->vatTotal = $param;
        return $this;
    }

    public function setTotal(string $param)
    {
        $this->total = $param;
        return $this;
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function getCustomer()
    {
        return $this->customer;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getScenario()
    {
        return $this->scenario;
    }

    public function getDocumentType()
    {
        return $this->documentType;
    }

    public function getPrefix()
    {
        return $this->prefix === null ? '' : $this->prefix;
    }

    public function getDate()
    {
        date_default_timezone_set('Europe/Istanbul');
        return $this->date === null ? date('m/d/Y H:i:s') : $this->date;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function getCurrencyRate()
    {
        return $this->currency;
    }

    public function getReferenceNo()
    {
        return $this->referenceNo;
    }

    public function getSubTotal()
    {
        return $this->subTotal;
    }

    public function getVatTotal()
    {
        return $this->vatTotal;
    }

    public function getTotal()
    {
        return $this->total;
    }
}
