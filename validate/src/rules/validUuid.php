<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validUuid extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (preg_match('/^[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}$/', $this->input) !== 1) {
            throw new ValidationFailed('%s is not a valid UUID.');
        }
    }
}
