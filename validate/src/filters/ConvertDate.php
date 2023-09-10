<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class ConvertDate extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumber($input);

        $options = ($options) ? $options : 'Y-m-d H:i:s';

        return date($options, strtotime((string)$input));
    }
}
