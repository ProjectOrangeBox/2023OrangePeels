<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Valid_url extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must contain a valid URL.';

        if (empty($field)) {
            return false;
        } elseif (preg_match('/^(?:([^:]*)\:)?\/\/(.+)$/', $field, $matches)) {
            if (empty($matches[2])) {
                return false;
            } elseif (!in_array($matches[1], ['http', 'https'], true)) {
                return false;
            }
            $field = $matches[2];
        }

        $field = 'http://' . $field;

        if (version_compare(PHP_VERSION, '5.2.13', '==') or version_compare(PHP_VERSION, '5.3.2', '==')) {
            sscanf($field, 'http://%[^/]', $host);
            $field = substr_replace($field, strtr($host, ['_' => '-', '-' => '_']), 7, strlen($host));
        }

        return (bool)(filter_var($field, FILTER_VALIDATE_URL) !== false);
    }
}
