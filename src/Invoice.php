<?php

namespace GurmesoftInvoice;

class Invoice
{
    public function setTaxNumber(string $param)
    {
        $this->taxNumber = $param;
        return $this;
    }
    
    public function setTaxOffice(string $param)
    {
        $this->taxOffice = $param;
        return $this;
    }

    public function setDate(string $param)
    {
        $this->date = $param;
        return $this;
    }

    public function getTaxNumber()
    {
        return $this->taxNumber;
    }
    
    public function getTaxOffice()
    {
        return $this->taxOffice;
    }
    
    public function getDate()
    {
        return $this->date;
    }
}
