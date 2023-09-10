<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class isArray extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        if (!is_array($input)) {
            throw new ValidationFailed('%s is not an array.');
        }
    }
}
