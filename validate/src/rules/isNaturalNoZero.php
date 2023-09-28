<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isNaturalNoZero extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (preg_match('/^-?\d{1,}$/', $this->input) !== 1 || $this->input === '0') {
            throw new ValidationFailed('%s is not a natural number greater than 0.');
        }
    }
}
