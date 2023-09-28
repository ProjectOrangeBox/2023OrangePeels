<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class ConvertDate extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        $options = ($options) ? $options : 'Y-m-d H:i:s';

        $this->input = date($options, strtotime($this->input));
    }
}
