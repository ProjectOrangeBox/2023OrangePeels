<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Str extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        if (!is_scalar($input) || is_bool($input)) {
            throw new ValidationFailed('%s is not filterable.');
        }

        $input = $this->human((string)$input);
        $input = $this->length($input, $options);

        return $input;
    }
}
