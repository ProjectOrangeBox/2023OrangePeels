<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Slug extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $field = preg_replace('~[^\pL\d]+~u', '-', $field);
        $field = iconv('utf-8', 'us-ascii//TRANSLIT', $field);
        $field = preg_replace('~[^-\w]+~', '', $field);
        $field = trim($field, '-');
        $field = preg_replace('~-+~', '-', $field);
        $field = strtolower($field);

        return $field;
    }
}
