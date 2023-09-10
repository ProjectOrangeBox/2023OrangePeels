<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validURL extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumber($input);

        if (filter_var($input, FILTER_VALIDATE_URL) === false) {
            throw new ValidationFailed('%s is not a valid URL.');
        }
    }
}
