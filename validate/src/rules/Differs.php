<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class Differs extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isOptionRequired($options);
        
        $currentValues = $this->parent->values();

        if (!isset($currentValues[$options])) {
            throw new ValidationFailed('Could not find the field ' . $options . '.');
        }

        if ($currentValues[$options] === $this->input) {
            throw new ValidationFailed('%s matches %s.');
        }
    }
}
