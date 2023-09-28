<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isDecimal extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (preg_match('/\A[-+]?\d{0,}\.?\d+\z/', $input) !== 1) {
            throw new ValidationFailed('%s is not a valid decimal value.');
        }
    }
}
