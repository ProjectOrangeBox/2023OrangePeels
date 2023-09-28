<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isHex extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (!ctype_xdigit((string)$input)) {
            throw new ValidationFailed('%s is not a hex value.');
        }
    }
}
