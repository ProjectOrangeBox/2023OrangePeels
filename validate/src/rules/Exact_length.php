<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Exact_length extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must be exactly %s characters in length.';

        if (!is_numeric($options)) {
            return false;
        }

        return (MB_ENABLED === true) ? (mb_strlen($field) === (int) $options) : (strlen($field) === (int) $options);
    }
}
