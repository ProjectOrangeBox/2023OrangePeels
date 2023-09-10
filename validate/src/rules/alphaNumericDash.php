<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class alphaNumericDash extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (preg_match('/^[A-Z0-9-]+$/i', (string)$input) !== 1) {
            throw new ValidationFailed('%s may only contain alpha characters, numbers, and dashes.');
        }
    }
}
