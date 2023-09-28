<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;

class Length extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isOptionInteger($options)->isStringNumber()->length($options);
    }
}
