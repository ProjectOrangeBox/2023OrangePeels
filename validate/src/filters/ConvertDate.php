<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class ConvertDate extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        if (!is_scalar($input) || is_bool($input)) {
            throw new ValidationFailed('%s is not filterable.');
        }

        $options = ($options) ? $options : 'Y-m-d H:i:s';

        return date($options, strtotime((string)$input));
    }
}
