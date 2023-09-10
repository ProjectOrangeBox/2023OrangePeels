<?php

declare(strict_types=1);

namespace peel\validate\abstract;

use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\FilterRuleInterface;

abstract class FilterAbstract extends ValidationRuleAbstract implements FilterRuleInterface
{
    private mixed $input = null;

    // must return "filtered" value
    public function filter(mixed $input, string $options = ''): mixed
    {
        return $input;
    }

    protected function return(): mixed
    {
        return $this->input;
    }

    protected function length($input, $length = null): self
    {
        if (is_numeric($length)) {
            $length = (int) $length;
            if ($length > 0) {
                $this->input = substr($input, 0, $length);
            }
        }

        return $this;
    }

    protected function human($input): self
    {
        $this->input = preg_replace("/[^\\x20-\\x7E]/mi", '', $input);

        return $this;
    }

    protected function humanPlus($input): self
    {
        $this->input = preg_replace("/[^\\x20-\\x7E\\n\\t\\r]/mi", '', $input);

        return $this;
    }

    protected function trim($input): self
    {
        $this->input = trim($input);

        return $this;
    }

    protected function strip($input, $strip): self
    {
        $this->input = str_replace(str_split($strip), '', $input);

        return $this;
    }
}
