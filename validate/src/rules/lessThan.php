<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class lessThan extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty();

        $this->isOptionInteger($options);

        if ((int)$this->input >= $options) {
            throw new ValidationFailed('%s is not less than %s.');
        }
    }
}
