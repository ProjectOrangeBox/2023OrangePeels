<?php

declare(strict_types=1);

namespace peel\validate\abstract;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\ValidateInterface;
use peel\validate\interfaces\ValidationRuleInterface;

abstract class ValidationRuleAbstract implements ValidationRuleInterface
{
    protected array $config = [];
    protected ValidateInterface $parent;

    public function __construct(array $config, ValidateInterface $parent)
    {
        $this->config = $config;
        $this->parent = $parent;
    }

    // throw error on fail
    public function isValid(mixed $input, string $options = ''): void
    {
    }

    protected function isBool($input): bool
    {
        return (in_array(strtolower($input), $this->config['isTrue'] + $this->config['isFalse'], true)) ? true : false;
    }

    protected function isStringNumber(&$input, string $errorMsg = null): void
    {
        if (!is_scalar($input) || is_bool($input) || $input === '') {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (string)$input;
    }

    protected function isStringNumberEmpty(&$input, string $errorMsg = null): void
    {
        if (!is_scalar($input) || is_bool($input)) {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (string)$input;
    }

    protected function isStringNumberBoolean(&$input, string $errorMsg = null): void
    {
        if (!is_scalar($input) || $input === '') {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (string)$input;
    }

    protected function isStringNumberBooleanEmpty(&$input, string $errorMsg = null): void
    {
        if (!is_scalar($input)) {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (string)$input;
    }

    protected function isArrayObject(&$input, string $errorMsg = null): void
    {
        if (!is_array($input) || !is_object($input) || $input === '') {
            $errorMsg = $errorMsg ?? '%s must be a array or object.';

            throw new ValidationFailed($errorMsg);
        }
    }

    protected function isInteger(&$input, string $errorMsg = null): void
    {
        if (preg_match('/^-?\d{1,}$/', (string)$input) !== 1) {
            $errorMsg = $errorMsg ?? '%s must be an integer.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (int)$input;
    }

    protected function isRequired(&$input, string $errorMsg = null): void
    {
        if ($input === '') {
            $errorMsg = $errorMsg ?? 'you must include a option for %s.';

            throw new ValidationFailed($errorMsg);
        }

        $input = (string)$input;
    }
}
