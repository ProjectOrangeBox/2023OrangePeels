<?php

declare(strict_types=1);

namespace dmyers\validate\interfaces;

interface ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool;
    public function fields(array &$fieldsData): self;
    public function errorString(string &$errorString): self;
}
