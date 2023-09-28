<?php

namespace peel\validate\filters;

use peel\validate\abstract\ValidationRuleAbstract;

class Human extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumber();

        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        convert to lowercase
        replace _ (underscore) characters with spaces
        uppercase words
        */
        $this->input = ucwords(str_replace('_', ' ', strtolower(trim(preg_replace('#\W+#', ' ', $this->input), ' '))));

        /* run of spaces */
        $this->input = \preg_replace('# +#', ' ', $this->input);

        /* options is max length */
        $this->length($options);
    }
}
