<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isUppercase extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (strtoupper($this->input) !== $this->input) {
            throw new ValidationFailed('%s does not contain uppercase characters.');
        }
    }
}
