<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Slug extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        if (!is_scalar($input) || is_bool($input)) {
            throw new ValidationFailed('%s is not filterable.');
        }

        $input = preg_replace('~[^\pL\d]+~u', '-', (string)$input);
        $input = iconv('utf-8', 'us-ascii//TRANSLIT', $input);
        $input = preg_replace('~[^-\w]+~', '', $input);
        $input = trim($input, '-');
        $input = preg_replace('~-+~', '-', $input);
        $input = strtolower($input);

        return $input;
    }
}
