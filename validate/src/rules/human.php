<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class human extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);

        if (preg_replace('/[\x00-\x1F\x7F]/u', '', $input) !== $input) {
            throw new ValidationFailed('%s contains invalid characters.');
        }
    }
}
