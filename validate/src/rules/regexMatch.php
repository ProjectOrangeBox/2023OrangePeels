<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class regexMatch extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($input);
        $this->isRequired($options);

        if (preg_match($options, $input) !== 1) {
            throw new ValidationFailed('Your regular expression for %s does not match.');
        }
    }
}
