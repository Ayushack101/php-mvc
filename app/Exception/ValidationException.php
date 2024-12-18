<?php

namespace App\Exception;

class ValidationException extends \Exception
{
    protected array $errors;

    public function __construct(array $errors)
    {
        parent::__construct("Validation failed");
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
