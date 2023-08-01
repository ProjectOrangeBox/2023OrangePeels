<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class ConvertDate extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $options = ($options) ? $options : 'Y-m-d H:i:s';

        return date($options, strtotime($field));
    }
}
