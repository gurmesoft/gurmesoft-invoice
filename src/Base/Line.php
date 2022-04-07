<?php

namespace GurmesoftInvoice\Base;

class Line
{
    protected $name;
    protected $quantity;
    protected $price;
    protected $vatRate;
    protected $unitCode;
    protected $stockCode;


    public function setName(string $param)
    {
        $this->name = $param;
        return $this;
    }

    public function setQuantity(int $param)
    {
        $this->quantity = $param;
        return $this;
    }

    public function setPrice(float $param)
    {
        $this->price = $param;
        return $this;
    }

    public function setVatRate(float $param)
    {
        $this->vatRate = $param;
        return $this;
    }

    public function setStockCode(string $param)
    {
        $this->stockCode = $param;
        return $this;
    }

    public function setUnitCode(string $param)
    {
        $this->unitCode = $param;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getVatRate()
    {
        return $this->vatRate;
    }

    public function getStockCode()
    {
        return $this->stockCode;
    }

    public function getUnitCode()
    {
        return $this->unitCode;
    }

    public function getVatTotal()
    {
        return ($this->getPrice() / 100 * $this->getVatRate()) * $this->getQuantity();
    }

    public function getTotal()
    {
        return $this->getVatTotal() + ($this->getPrice() * $this->getQuantity());
    }
}
