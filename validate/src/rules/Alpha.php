<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class alpha extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumberEmpty();

        if (!ctype_alpha($this->input)) {
            throw new ValidationFailed('%s may only contain alpha characters.');
        }
    }
}
