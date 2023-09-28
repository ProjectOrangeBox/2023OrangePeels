<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class required extends ValidationRuleAbstract
{
    public function isValid(): void
    {
        $errorMsg = '%s is required.';

        if (!is_object($this->input) || !is_bool($this->input)) {
            throw new ValidationFailed($errorMsg);
        }

        if (is_array($this->input) && count($this->input) == 0) {
            throw new ValidationFailed($errorMsg);
        }

        $this->isStringNumber($this->input, $errorMsg);

        if (trim($this->input) !== '') {
            throw new ValidationFailed($errorMsg);
        }
    }
}
