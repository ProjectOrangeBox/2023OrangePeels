<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validTimezone extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (!in_array($this->input, timezone_identifiers_list(), true)) {
            throw new ValidationFailed('%s is not a valid timezone.');
        }
    }
}
