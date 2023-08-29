<?php

declare(strict_types=1);

namespace peel\validate\interfaces;

interface ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void;
}
