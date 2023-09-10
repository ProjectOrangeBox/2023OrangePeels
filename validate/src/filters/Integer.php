<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Integer extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumber($input);

        $pos = strpos((string)$input, '.');

        if ($pos !== false) {
            $input = substr($input, 0, $pos);
        }

        $input  = preg_replace('/[^\-\+0-9]+/', '', $input);
        $prefix = ($input[0] == '-' || $input[0] == '+') ? $input[0] : '';
        $input  = $prefix . preg_replace('/[^0-9]+/', '', $input);

        return $this->length($input, $options)->return();
    }
}
