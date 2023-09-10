<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validTimezone extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumber($input);

        if (!in_array($input, timezone_identifiers_list(), true)) {
            throw new ValidationFailed('%s is not a valid timezone.');
        }
    }
}
