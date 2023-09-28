<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class alphaNumeric extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (!ctype_alnum($input)) {
            throw new ValidationFailed('%s may only contain alpha characters and numbers.');
        }
    }
}
