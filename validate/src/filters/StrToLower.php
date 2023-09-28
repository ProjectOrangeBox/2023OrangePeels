<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class StrToLower extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        $this->input = strtolower($this->input);
    }
}
