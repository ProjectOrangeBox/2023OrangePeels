<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Regex_match extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        if (empty($options)) {
            $this->errorString = '%s expression match option empty.';

            return false;
        }

        $this->errorString = '%s is not in the correct format.';

        return (bool) preg_match($options, $field);
    }
}
