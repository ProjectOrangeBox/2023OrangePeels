<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;


class Filename extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        */
        $this->input = \strtolower(\trim(\preg_replace('#\W+#', '_', $this->input), '_'));

        $this->input = \preg_replace('#_+#', '_', $this->input);

        /* options is max length */
        $this->length($options);
    }
}
