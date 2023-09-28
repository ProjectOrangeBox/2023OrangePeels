<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Str extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber()->human()->length($options);
    }
}
