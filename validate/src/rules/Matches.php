<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class Matches extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $currentValues = $this->parent->values();

        if (!isset($currentValues[$options])) {
            throw new ValidationFailed('Could not find the field ' . $options . '.');
        }

        if ($currentValues[$options] !== $input) {
            throw new ValidationFailed('%s does not match %s.');
        }
    }
}
