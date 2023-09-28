<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validURL extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (filter_var($this->input, FILTER_VALIDATE_URL) === false) {
            throw new ValidationFailed('%s is not a valid URL.');
        }
    }
}
