<?php

namespace GurmesoftInvoice;

class Customer
{
    protected $taxNumber;
    protected $taxOffice;
    protected $firstName;
    protected $lastName;
    protected $company;
    protected $email;
    protected $phone;
    protected $address;
    protected $district;
    protected $city;
    protected $country;

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

    public function setFirstName(string $param)
    {
        $this->firstName = $param;
        return $this;
    }

    public function setLastName(string $param)
    {
        $this->lastName = $param;
        return $this;
    }

    public function setCompany(string $param)
    {
        $this->company = $param;
        return $this;
    }

    public function setEmail(string $param)
    {
        $this->email = $param;
        return $this;
    }

    public function setPhone(string $param)
    {
        $this->phone = $param;
        return $this;
    }

    public function setAddress(string $param)
    {
        $this->address = $param;
        return $this;
    }

    public function setDistrict(string $param)
    {
        $this->district = $param;
        return $this;
    }

    public function setCity(string $param)
    {
        $this->city = $param;
        return $this;
    }

    public function setCountry(string $param)
    {
        $this->country = $param;
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getCountry()
    {
        return $this->country;
    }
}
