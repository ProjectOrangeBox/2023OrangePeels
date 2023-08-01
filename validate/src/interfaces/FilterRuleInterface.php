<?php

declare(strict_types=1);

namespace dmyers\validate\interfaces;

interface FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed;
}
