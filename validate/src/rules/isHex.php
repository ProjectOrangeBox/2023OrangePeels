<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class isHex extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumberEmpty();

        if (!ctype_xdigit((string)$this->input)) {
            throw new ValidationFailed('%s is not a hex value.');
        }
    }
}
