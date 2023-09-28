<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isUppercase extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumber($input);

        if (strtoupper($input) !== $input) {
            throw new ValidationFailed('%s does not contain uppercase characters.');
        }
    }
}
