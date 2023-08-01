<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Less_than extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain a number less than %s.';

        if (!is_numeric($field)) {
            return false;
        }

        return is_numeric($field) ? ($field < $options) : false;
    }
}
