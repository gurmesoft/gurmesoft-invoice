<?php

namespace GurmesoftInvoice\Base;

class Invoice
{

    protected $lines;
    protected $customer;
    protected $date;
    protected $currency;
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

    public function setDate(string $param)
    {
        $this->date = $param;
        return $this;
    }

    public function setCurrency(string $param)
    {
        $this->currency = $param;
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
    
    public function getDate()
    {
        return $this->date;
    }

    public function getCurrency()
    {
        return $this->currency;
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
