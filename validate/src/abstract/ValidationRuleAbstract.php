<?php

declare(strict_types=1);

namespace peel\validate\abstract;

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
}
