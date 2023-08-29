<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class allowEmpty extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        // a valid object or bool value
        if (is_object($input) || is_bool($input)) {
            // already contain something so return
            return;
        }

        // a array with more than 1 entry
        if (is_array($input) && count($input) > 0) {
            // already contain something so return
            return;
        }

        // something else?
        if (is_scalar($input)) {
            if (trim((string)$input) === '') {
                // this is ok
                $this->parent->stopProcessing();
            }
        }
    }
}
