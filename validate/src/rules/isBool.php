<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class isBool extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isBool()->return();
    }
}
