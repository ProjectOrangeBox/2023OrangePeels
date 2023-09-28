<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Trim extends ValidationRuleAbstract
{
    public function filter(): void
    {
        $this->isStringNumber()->trim();
    }
}
