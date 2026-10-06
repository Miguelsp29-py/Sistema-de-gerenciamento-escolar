<?php

namespace Api\Http;

use Exception;

class ErrorResponse extends Exception
{
    private int $httpCode;

    private $error;

    private string $name;

    public function __construct(int $httpCode, string $message, $error = null)
    {
        parent::__construct($message);
        $this->name = "ErrorResponse";
        $this->httpCode = $httpCode;
        $this->error = $error;
    }

    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
