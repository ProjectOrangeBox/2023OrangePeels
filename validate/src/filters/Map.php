<?php

namespace peel\validate\filters;

use peel\validate\abstract\FilterAbstract;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\interfaces\FilterRuleInterface;

class Map extends FilterAbstract implements FilterRuleInterface
{
    public function filter(mixed $input, string $options = ''): mixed
    {
        $this->isStringNumberEmpty($input);

        $map = [];
        $groups = explode(';', $options);

        foreach ($groups as $group) {
            list($key, $value) = explode(':', $group, 2);
            $map[$key] = $value;
        }

        if (!array_key_exists($input, $map)) {
            throw new ValidationFailed('Could not map %s.');
        }

        return $map[$input];
    }
}
