<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class alphaSpace extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumberEmpty($this->input);

        if (preg_match('/^[A-Z ]+$/i', $this->input) !== 1) {
            throw new ValidationFailed('%s may only contain alpha characters and spaces.');
        }
    }
}
