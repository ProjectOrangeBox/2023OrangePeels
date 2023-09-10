<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Human extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumber($input);

        /*
        only word characters - from a-z, A-Z, 0-9, including the _ (underscore) character
        then trim any _ (underscore) characters from the beginning and end of the string
        convert to lowercase
        replace _ (underscore) characters with spaces
        uppercase words
        */
        $input = ucwords(str_replace('_', ' ', strtolower(trim(preg_replace('#\W+#', ' ', (string)$input), ' '))));

        /* run of spaces */
        $input = \preg_replace('# +#', ' ', $input);

        /* options is max length */
        return $this->length($input, $options)->return();
    }
}
