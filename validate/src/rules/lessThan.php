<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class lessThan extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumberEmpty($input);
        $this->isInteger($options);

        if ($input < $options) {
            throw new ValidationFailed('%s is not less than %s.');
        }
    }
}
