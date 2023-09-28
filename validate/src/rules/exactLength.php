<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class exactLength extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumberEmpty($this->input);
        
        $this->isOptionInteger($options);

        if ($options !== strlen($this->input)) {
            throw new ValidationFailed('%s is not %s in length.');
        }
    }
}
