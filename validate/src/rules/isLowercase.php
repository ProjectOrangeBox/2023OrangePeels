<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isLowercase extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (strtolower($this->input) !== $this->input) {
            throw new ValidationFailed('%s does not contain lowercase characters.');
        }
    }
}
