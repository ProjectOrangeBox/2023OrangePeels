<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validJson extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        // level 1 because single scalar values are actually valid?
        $first = substr(trim($this->input), 0, 1);

        if ($first !== '[' && $first !== '{') {
            throw new ValidationFailed('%s is not a valid JSON.1');
        }

        // level 2
        $json = json_decode($this->input);

        if (!is_object($json) && !is_array($json)) {
            throw new ValidationFailed('%s is not a valid JSON.3');
        }
    }
}
