<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;

class StrToUpper extends ValidationRuleAbstract
{
    public function filter(): void
    {
        $this->isStringNumber();
        
        $this->input = strtoupper($this->input);
    }
}
