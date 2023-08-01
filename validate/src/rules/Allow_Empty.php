<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

/**
 * this class is actually a dummy class which is never called
 * internally validate checks for the allow_empty rules
 * if the field IS empty then it returns false which stop processing
 * but this isn't an error so no error is registered
 */
class Allow_Empty extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        return true;
    }
}
