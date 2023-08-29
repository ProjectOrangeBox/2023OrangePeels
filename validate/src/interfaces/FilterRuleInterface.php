<?php

declare(strict_types=1);

namespace peel\validate\interfaces;

interface FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed;
}
