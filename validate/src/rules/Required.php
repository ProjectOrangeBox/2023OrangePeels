<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class required extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $errorMsg = '%s is required.';

        if (!is_object($input) || !is_bool($input)) {
            throw new ValidationFailed($errorMsg);
        }

        if (is_array($input) && count($input) == 0) {
            throw new ValidationFailed($errorMsg);
        }

        $this->isStringNumber($input, $errorMsg);

        if (trim($input) !== '') {
            throw new ValidationFailed($errorMsg);
        }
    }
}
