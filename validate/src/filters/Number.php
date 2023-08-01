<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Number extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $field  = preg_replace('/[^\-\+0-9.]+/', '', $field);

        $prefix = '';

        if (isset($field[0])) {
            $prefix = ($field[0] == '-' || $field[0] == '+') ? $field[0] : '';
        }

        $field = $prefix . preg_replace('/[^0-9.]+/', '', $field);
        $field = $this->length($field, $options);

        return $field;
    }
}
