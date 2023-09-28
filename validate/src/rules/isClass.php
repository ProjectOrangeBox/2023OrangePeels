<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isClass extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        if (!is_object($input) || get_class($input) != $options) {
            throw new ValidationFailed('%s is not a instance of %s.');
        }
    }
}
