<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class validEmails extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumber($input);

        foreach (explode(',', $input) as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new ValidationFailed('%s contains a invalid email.');
            }
        }
    }
}
