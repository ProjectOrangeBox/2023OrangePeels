<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Alpha extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s may only contain alphabetical characters.';

        return (bool) ctype_alpha($field);
    }
}
