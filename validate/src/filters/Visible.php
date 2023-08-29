<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Visible extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        if (!is_scalar($input) || is_bool($input)) {
            throw new ValidationFailed('%s is not filterable.');
        }

        $input = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', (string)$input);
        $input = $this->length($input, $options);

        return $input;
    }
}
