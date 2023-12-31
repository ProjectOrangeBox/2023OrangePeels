<?php

declare(strict_types=1);

namespace peel\validate\rules;

use DateTime;
use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;

class validDate extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $errorMsg = '%s is not a valid date/time value.';

        $this->isStringNumber();

        if (empty($options)) {
            if (strtotime($this->input) === false) {
                throw new ValidationFailed($errorMsg);
            }
        }

        $date   = DateTime::createFromFormat($options, $this->input);

        if ($date === false) {
            throw new ValidationFailed($errorMsg);
        }

        $errors = DateTime::getLastErrors();

        // PHP 8.2 or later.
        if (is_bool($errors)) {
            if ($errors !== false) {
                throw new ValidationFailed($errorMsg);
            }
        }

        // before 8.2
        if ($errors['warning_count'] !== 0 || $errors['error_count'] !== 0) {
            throw new ValidationFailed($errorMsg);
        }
    }
}
