<?php

declare(strict_types=1);

namespace peel\validate\abstract;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\ValidateInterface;

abstract class ValidationRuleAbstract
{
    // this allows us to chain methods
    protected mixed $input = null;
    protected array $config = [];
    protected ValidateInterface $parent;

    public function __construct(mixed &$input, array $config, ValidateInterface $parent)
    {
        // work on reference
        $this->input = &$input;

        $this->config = $config;
        $this->parent = $parent;
    }

    protected function convert2bool(): mixed
    {
        $bool = null;

        $val = strtolower($this->input);

        if (in_array($val, $this->config['isTrue'] + $this->config['isFalse'], true)) {
            $bool = in_array($val, $this->config['isTrue'], true);
        }

        return $bool;
    }

    protected function isBool(string $errorMsg = null): self
    {
        $value = $this->convert2bool();

        if ($value === null) {
            $errorMsg = $errorMsg ?? '%s is not considered a boolean value.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = $value;

        return $this;
    }

    protected function isStringNumber(string $errorMsg = null): self
    {
        if (!is_scalar($this->input) || is_bool($this->input) || $this->input === '') {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (string)$this->input;

        return $this;
    }

    protected function isStringNumberEmpty(string $errorMsg = null): self
    {
        if (!is_scalar($this->input) || is_bool($this->input)) {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (string)$this->input;

        return $this;
    }

    protected function isStringNumberBoolean(string $errorMsg = null): self
    {
        if (!is_scalar($this->input) || $this->input === '') {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (string)$this->input;

        return $this;
    }

    protected function isStringNumberBooleanEmpty(string $errorMsg = null): self
    {
        if (!is_scalar($this->input)) {
            $errorMsg = $errorMsg ?? '%s must be a string or numbers.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (string)$this->input;

        return $this;
    }

    protected function isArrayObject(string $errorMsg = null): self
    {
        if (!is_array($this->input) || !is_object($this->input) || $this->input === '') {
            $errorMsg = $errorMsg ?? '%s must be a array or object.';

            throw new ValidationFailed($errorMsg);
        }

        return $this;
    }

    protected function isInteger(string $errorMsg = null): self
    {
        if (preg_match('/^-?\d{1,}$/', (string)$this->input) !== 1) {
            $errorMsg = $errorMsg ?? '%s must be an integer.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (int)$this->input;

        return $this;
    }

    protected function isOptionInteger(mixed &$input): self
    {
        if (preg_match('/^-?\d{1,}$/', (string)$input) !== 1) {
            throw new ValidationFailed('%s must be an integer.');
        }

        $input = (int)$input;

        return $this;
    }

    protected function isOptionRequired(mixed $input): self
    {
        if ($input === '') {
            throw new ValidationFailed('you must include a option for %s.');
        }

        return $this;
    }

    protected function isRequired(string $errorMsg = null): self
    {
        if ($this->input === '') {
            $errorMsg = $errorMsg ?? 'you must include a option for %s.';

            throw new ValidationFailed($errorMsg);
        }

        $this->input = (string)$this->input;

        return $this;
    }

    protected function length($length = null): self
    {
        if (is_numeric($length)) {
            
            $length = (int) $length;

            if ($length > 0) {
                $this->input = substr((string)$this->input, 0, $length);
            }
        }

        return $this;
    }

    protected function human(): self
    {
        $this->input = preg_replace("/[^\\x20-\\x7E]/mi", '', (string)$this->input);

        return $this;
    }

    protected function humanPlus(): self
    {
        $this->input = preg_replace("/[^\\x20-\\x7E\\n\\t\\r]/mi", '', (string)$this->input);

        return $this;
    }

    protected function trim(): self
    {
        $this->input = trim((string)$this->input);

        return $this;
    }

    protected function strip($strip): self
    {
        $this->input = str_replace(str_split($strip), '', (string)$this->input);

        return $this;
    }
}
