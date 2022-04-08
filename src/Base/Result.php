<?php

namespace GurmesoftInvoice\Base;

class Result
{
    protected $isSuccess        = false;
    protected $isEFatura        = false;
    protected $product          = false;
    protected $reference        = false;
    protected $status           = false;
    protected $list             = false;
    protected $errorMessage     = false;
    protected $errorCode        = false;
    protected $response         = false;
    
    public function setResponse($param)
    {
        $this->response = $param;
        return $this;
    }

    public function setReference(string $param)
    {
        $this->reference = $param;
        return $this;
    }

    public function setStatus(string $param)
    {
        $this->status = $param;
        return $this;
    }

    public function setProduct(string $param)
    {
        $this->product = $param;
        return $this;
    }

    public function setList(string $param)
    {
        $this->list = $param;
        return $this;
    }

    public function setErrorMessage(string $param)
    {
        $this->errorMessage = $param;
        return $this;
    }

    public function setErrorCode(string $param)
    {
        $this->errorCode = $param;
        return $this;
    }

    public function setIsSuccess(bool $param)
    {
        $this->isSuccess = $param;
        return $this;
    }

    public function setIsEFatura(bool $param)
    {
        $this->isEFatura = $param;
        return $this;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getReference()
    {
        return $this->reference;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getList()
    {
        return $this->list;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function isSuccess()
    {
        return $this->isSuccess;
    }

    public function isEFatura()
    {
        return $this->isEFatura;
    }
}
