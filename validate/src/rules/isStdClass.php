<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isStdClass extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        if (!is_object($this->input) || get_class($this->input) == stdClass::class) {
            throw new ValidationFailed('%s is not a Standard Class.');
        }
    }
}
