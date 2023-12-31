<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validBase64 extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $this->isStringNumber();

        if (base64_decode($this->input, true) === false) {
            throw new ValidationFailed('%s is not a valid base64 value.');
        }
    }
}
