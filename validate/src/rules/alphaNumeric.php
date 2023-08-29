<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class alphaNumeric extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        if (!is_scalar($input) || is_bool($input) || $input === '' || !ctype_alnum((string) $input)) {
            throw new ValidationFailed('%s may only contain alpha characters and numbers.');
        }
    }
}
