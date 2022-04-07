<?php

namespace GurmesoftInvoice\Base;

class Result
{
    protected $response         = false;
    protected $reference        = false;
    protected $status           = false;
    protected $errorMessage     = false;
    protected $errorCode        = false;
    protected $isSuccess        = false;

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
}
