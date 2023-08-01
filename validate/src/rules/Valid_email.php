<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Valid_email extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain a valid email address.';

        if (count(explode('@', $field)) !== 2) {
            return false;
        }

        if (function_exists('idn_to_ascii') && $atpos = strpos($field, '@')) {
            $field = substr($field, 0, ++$atpos) . idn_to_ascii(substr($field, $atpos));
        }

        return (bool) filter_var($field, FILTER_VALIDATE_EMAIL);
    }
}
