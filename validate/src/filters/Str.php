<?php

namespace dmyers\validate\filters;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\FilterRuleInterface;

class Str extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $field, string $options = ''): mixed
    {
        $field = $this->human($field);
        $field = $this->length($field, $options);

        return $field;
    }
}
