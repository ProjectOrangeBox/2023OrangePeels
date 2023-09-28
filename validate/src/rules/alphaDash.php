<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class alphaDash extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (preg_match('/^[A-Z-]+$/i', $input) !== 1) {
            throw new ValidationFailed('%s may only contain alpha characters and dashes.');
        }
    }
}
