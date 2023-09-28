<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isArray extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        if (!is_array($input)) {
            throw new ValidationFailed('%s is not an array.');
        }
    }
}
