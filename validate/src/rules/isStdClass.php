<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isStdClass extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        if (!is_object($input) || get_class($input) == stdClass::class) {
            throw new ValidationFailed('%s is not a Standard Class.');
        }
    }
}
