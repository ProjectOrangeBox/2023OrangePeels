<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Textarea extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isOptionInteger($options);

        $this->isStringNumber()->humanPlus()->length($options);
    }
}
