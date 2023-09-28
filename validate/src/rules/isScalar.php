<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\abstract\ValidationRuleAbstract;

class isScalar extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumberBoolean($this->input);
    }
}
