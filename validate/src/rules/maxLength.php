<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class maxLength extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty();

        $this->isOptionInteger($options);

        if (strlen($this->input) > $options) {
            throw new ValidationFailed('%s is longer than %s.');
        }
    }
}
