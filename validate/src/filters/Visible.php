<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;

class Visible extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isOptionInteger($options)->isStringNumber();

        $this->input = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $this->input);

        $this->length($options);
    }
}
