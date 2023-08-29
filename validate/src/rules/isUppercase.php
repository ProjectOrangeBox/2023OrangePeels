<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class isUppercase extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        if (!is_scalar($input) || is_bool($input) || $input === '' || !(strtoupper($input) == (string)$input)) {
            throw new ValidationFailed('%s may only contain uppercase letters.');
        }
    }
}
