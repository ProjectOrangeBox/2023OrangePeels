<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Human extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        convert to lowercase
        replace _ (underscore) characters with spaces
        uppercase words
        */
        $field = ucwords(str_replace('_', ' ', strtolower(trim(preg_replace('#\W+#', ' ', $field), ' '))));

        /* run of spaces */
        $field = \preg_replace('# +#', ' ', $field);

        /* options is max length */
        $field = $this->length($field, $options);

        return $field;
    }
}
