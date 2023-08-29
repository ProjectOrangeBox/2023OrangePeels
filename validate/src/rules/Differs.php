<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class Differs extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {

        if (!is_scalar($input) || is_bool($input) || !is_scalar($options)) {
            throw new ValidationFailed('%s may only contain a scalar value.');
        }

        //$this->errorString = '%s must differ from %s.';
        $currentValues = $this->parent->values();

        if (!isset($currentValues[$options])) {
            throw new ValidationFailed('Could not find the field ' . $options . '.');
        }

        if ($currentValues[$options] !== $input) {
            throw new ValidationFailed('The fields don\'t match.');
        }
    }
}
