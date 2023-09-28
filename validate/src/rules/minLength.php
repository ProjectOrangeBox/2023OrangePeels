<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class minLength extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);
        $this->isInteger($options);

        if (strlen($input) < $options) {
            throw new ValidationFailed('%s is shorter than %s.');
        }
    }
}
