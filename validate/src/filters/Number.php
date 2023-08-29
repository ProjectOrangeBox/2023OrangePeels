<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Number extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        if (!is_scalar($input) || is_bool($input)) {
            throw new ValidationFailed('%s is not filterable.');
        }

        $input  = preg_replace('/[^\-\+0-9.]+/', '', (string)$input);

        $prefix = '';

        if (isset($input[0])) {
            $prefix = ($input[0] == '-' || $input[0] == '+') ? $input[0] : '';
        }

        $input = $prefix . preg_replace('/[^0-9.]+/', '', $input);
        $input = $this->length($input, $options);

        return $input;
    }
}
