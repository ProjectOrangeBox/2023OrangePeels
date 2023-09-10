<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Filename extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumber($input);

        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        */
        $input = \strtolower(\trim(\preg_replace('#\W+#', '_', (string)$input), '_'));

        $input = \preg_replace('#_+#', '_', $input);

        /* options is max length - filter is in orange core */
        return $this->length($input, $options)->return();
    }
}
