<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Number extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        $this->input = preg_replace('/[^\-\+0-9.]+/', '', $this->input);

        $prefix = '';

        if (isset($this->input[0])) {
            $prefix = ($this->input[0] == '-' || $this->input[0] == '+') ? $this->input[0] : '';
        }

        $this->input = $prefix . preg_replace('/[^0-9.]+/', '', $this->input);

        $this->length($options);
    }
}
