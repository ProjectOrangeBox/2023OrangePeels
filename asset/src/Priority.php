<?php

declare(strict_types=1);

namespace peel\asset;

use peel\asset\Interfaces\PriorityInterface;

class Priority implements PriorityInterface
{
    protected array $data = [];

    public function has(string $name): bool
    {
        return isset($this->data[$this->normalizeName($name)]);
    }

    public function get(string $name): mixed
    {
        $name = $this->normalizeName($name);
        $outputText = '';

        if ($this->has($name)) {
            /* sort priority */
            ksort($this->data[$name]);

            /* now build our output */
            foreach ($this->data[$name] as $value) {
                $outputText .= $value;
            }
        }

        return $outputText;
    }

    /* add something with priority */
    public function add(string $name, string $value, bool|int $append = true, int $priority = self::NORMAL): self
    {
        // if they pass the priority in arg 3 then swap
        if (is_int($append)) {
            $priority = $append;
            $append = true;
        }

        $name = $this->normalizeName($name);
        $order = floatval((string)$priority . (string)\hrtime(true));

        if (!$append && $this->has($name)) {
            unset($this->data[$name]);
        }

        $this->data[$name][$order] = $value;

        return $this;
    }

    public function addMultiple(array $array, bool|int $append = true, int $priority = self::NORMAL): self
    {
        foreach ($array as $name => $value) {
            $this->add($name, $value, $append, $priority);
        }

        return $this;
    }

    /* protected */

    protected function normalizeName(string $trigger): string
    {
        return mb_convert_case($trigger, MB_CASE_LOWER, mb_detect_encoding($trigger));
    }
}
