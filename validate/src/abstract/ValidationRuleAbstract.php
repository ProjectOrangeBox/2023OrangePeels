<?php

declare(strict_types=1);

namespace dmyers\validate\abstract;

use dmyers\validate\abstract\FilterAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

abstract class ValidationRuleAbstract extends FilterAbstract implements ValidationRuleInterface
{
    protected array $fieldsData; /* all fields */
    protected string $errorString = '';

    public function isValid(mixed $field, string $options = ''): bool
    {
        return false;
    }

    public function fields(array &$fieldsData): self
    {
        $fieldsData = &$fieldsData;

        return $this;
    }

    public function errorString(string &$errorString): self
    {
        $this->errorString = &$errorString;

        return $this;
    }
}
