<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isNatural extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumber($input);

        if (preg_match('/^-?\d{1,}$/', $input) !== 1) {
            throw new ValidationFailed('%s is not a natural number.');
        }
    }
}
