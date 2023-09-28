<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class StrToUpper extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();
        
        $this->input = strtoupper($this->input);
    }
}
