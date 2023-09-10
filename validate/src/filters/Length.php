<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Length extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumber($input);

        return $this->length((string)$input, $options)->return();
    }
}
