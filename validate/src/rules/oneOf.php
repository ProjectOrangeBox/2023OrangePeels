<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class oneOf extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty();

        if (!in_array($this->input, explode(',', $options), true)) {
            throw new ValidationFailed('%s is not one of %3$s.');
        }
    }
}
