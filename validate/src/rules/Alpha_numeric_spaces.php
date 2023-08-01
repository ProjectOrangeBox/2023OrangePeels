<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Alpha_numeric_spaces extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s may only contain alpha-numeric characters and spaces.';

        return (bool) preg_match('/^[A-Z0-9 ]+$/i', $field);
    }
}
