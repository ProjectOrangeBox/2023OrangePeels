<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Str extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isOptionInteger($options);

        $this->isStringNumber()->human()->length($options);
    }
}
