<?php

declare(strict_types=1);

namespace dmyers\validate\abstract;

abstract class FilterAbstract
{
    protected array $trueArray = [1, '1', 'y', 'on', 'yes', 't', 'true', true];
    protected array $falseArray = [0, '0', 'n', 'off', 'no', 'f', 'false', false];

    public function filter(mixed $field, string $options = ''): mixed
    {
        return $field;
    }

    protected function length($field, $length = null): mixed
    {
        if (is_numeric($length)) {
            $length = (int) $length;
            if ($length > 0) {
                $field = substr($field, 0, $length);
            }
        }

        return $field;
    }

    protected function human($field): mixed
    {
        return preg_replace("/[^\\x20-\\x7E]/mi", '', $field);
    }

    protected function humanPlus($field): mixed
    {
        return preg_replace("/[^\\x20-\\x7E\\n\\t\\r]/mi", '', $field);
    }

    protected function trim($field)
    {
        return trim($field);
    }

    protected function strip($field, $strip)
    {
        return str_replace(str_split($strip), '', $field);
    }

    protected function isBool($field): bool
    {
        return (in_array(strtolower($field), array_merge($this->trueArray, $this->falseArray), true)) ? true : false;
    }
}
