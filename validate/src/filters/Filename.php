<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Filename extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        */
        $field = \strtolower(\trim(\preg_replace('#\W+#', '_', $field), '_'));

        $field = \preg_replace('#_+#', '_', $field);

        /* options is max length - filter is in orange core */
        return $this->length($field, $options);
    }
}
