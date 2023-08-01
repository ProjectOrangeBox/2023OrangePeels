<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Valid_emails extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain all valid email addresses.';

        foreach (explode(',', $field) as $email) {
            /* bail on first failure */
            if (trim($email) !== '' && $this->valid_email(trim($email)) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     *
     * validate individual email address
     *
     * @access public
     *
     * @param string $field email address
     *
     * @return bool success
     *
     */
    public function valid_email(string $field)
    {
        $this->errorString = '%s must contain a valid email address.';

        if (function_exists('idn_to_ascii') && $atpos = strpos($field, '@')) {
            $field = substr($field, 0, ++$atpos) . idn_to_ascii(substr($field, $atpos));
        }

        return (bool)filter_var($field, FILTER_VALIDATE_EMAIL);
    }
}
