<?php

namespace peel\validate\filters;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class Map extends ValidationRuleAbstract
{
    public function filter(string $options = ''): void
    {
        $this->isStringNumberEmpty();

        $map = [];
        $groups = explode(';', $options);

        foreach ($groups as $group) {
            list($key, $value) = explode(':', $group, 2);
            $map[$key] = $value;
        }

        if (!array_key_exists($this->input, $map)) {
            throw new ValidationFailed('Could not map %s.');
        }

        $this->input = $map[$this->input];
    }
}
