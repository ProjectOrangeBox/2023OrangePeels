<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validJson extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumber($input);

        // level 1 because single scalar values are actually valid?
        $first = substr(trim($input), 0, 1);

        if ($first !== '[' && $first !== '{') {
            throw new ValidationFailed('%s is not a valid JSON.1');
        }

        // level 2
        $json = json_decode($input);

        if (!is_object($json) && !is_array($json)) {
            throw new ValidationFailed('%s is not a valid JSON.3');
        }
    }
}
