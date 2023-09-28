<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Integer extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        $pos = strpos($this->input, '.');

        if ($pos !== false) {
            $this->input = substr($this->input, 0, $pos);
        }

        $this->input  = preg_replace('/[^\-\+0-9]+/', '', $this->input);
        
        $prefix = ($this->input[0] == '-' || $this->input[0] == '+') ? $this->input[0] : '';
        
        $this->input  = $prefix . preg_replace('/[^0-9]+/', '', $this->input);

        $this->length($options);
    }
}
