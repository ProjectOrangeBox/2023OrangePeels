<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isClass extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isOptionRequired($options);

        if (!is_object($this->input) || get_class($this->input) != $options) {
            throw new ValidationFailed('%s is not a instance of %s.');
        }
    }
}
