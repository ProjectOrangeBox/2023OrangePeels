<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class regexMatch extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->isStringNumberEmpty($input);
        $this->isRequired($options);

        if (preg_match($options, $input) !== 1) {
            throw new ValidationFailed('Your regular expression for %s does not match.');
        }
    }
}
