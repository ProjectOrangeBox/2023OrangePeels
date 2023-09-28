<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class alphaNumeric extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumberEmpty($this->input);

        if (!ctype_alnum($this->input)) {
            throw new ValidationFailed('%s may only contain alpha characters and numbers.');
        }
    }
}
