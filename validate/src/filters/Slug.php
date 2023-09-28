<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Slug extends ValidationRuleAbstract
{
    public function filter(): void
    {
        $this->isStringNumber();

        $this->input = preg_replace('~[^\pL\d]+~u', '-', $this->input);
        $this->input = iconv('utf-8', 'us-ascii//TRANSLIT', $this->input);
        $this->input = preg_replace('~[^-\w]+~', '', $this->input);
        $this->input = trim($this->input, '-');
        $this->input = preg_replace('~-+~', '-', $this->input);

        $this->input = strtolower($this->input);
    }
}
