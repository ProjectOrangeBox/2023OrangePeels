<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class lessThanEqualTo extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty();
        
        $this->isOptionInteger($options);

        if ($this->input <= $options) {
            throw new ValidationFailed('%s is not less than or equal to %s.');
        }
    }
}
