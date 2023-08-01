<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Visible extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $field = preg_replace('/[\x00-\x1F\x7F\xA0]/u', '', $field);
        $field = $this->length($field, $options);

        return $field;
    }
}
