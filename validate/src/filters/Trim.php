<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Trim extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber()->trim();
    }
}
