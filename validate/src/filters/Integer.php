<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Integer extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $pos = strpos($field, '.');

        if ($pos !== false) {
            $field = substr($field, 0, $pos);
        }

        $field  = preg_replace('/[^\-\+0-9]+/', '', $field);
        $prefix = ($field[0] == '-' || $field[0] == '+') ? $field[0] : '';
        $field  = $prefix . preg_replace('/[^0-9]+/', '', $field);

        $field = $this->length($field, $options);

        return $field;
    }
}
