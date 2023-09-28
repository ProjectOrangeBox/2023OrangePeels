<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class greaterThan extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty();
        
        $this->isOptionRequired($options);

        if ((int)$this->input <= $options) {
            throw new ValidationFailed('%s is not greater than %3$s.');
        }
    }
}
