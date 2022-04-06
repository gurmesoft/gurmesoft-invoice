<?php

namespace GurmesoftInvoice;

class Line
{
    protected $code;
    protected $name;
    protected $quantity;
    protected $price;
    protected $vatRate;

    public function setCode(string $param)
    {
        $this->code = $param;
        return $this;
    }

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

    public function getCode()
    {
        return $this->code;
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
}
