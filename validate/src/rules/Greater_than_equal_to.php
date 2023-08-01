<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Greater_than_equal_to extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain a number greater than or equal to %s.';

        if (!is_numeric($field)) {
            return false;
        }

        return is_numeric($field) ? ($field >= $options) : false;
    }
}