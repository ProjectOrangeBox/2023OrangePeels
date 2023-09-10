<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class isLowercase extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumber($input);

        if (strtolower($input) !== $input) {
            throw new ValidationFailed('%s does not contain lowercase characters.');
        }
    }
}
