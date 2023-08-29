<?php

declare(strict_types=1);

namespace peel\validate\exceptions;

class ValidationFailed extends \Exception
{
    protected array $errors = [];

    public function __construct(string $string = '', array $errors = [])
    {
        parent::__construct($string);

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
