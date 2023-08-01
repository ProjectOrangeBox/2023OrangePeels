<?php

declare(strict_types=1);

namespace dmyers\validate\rules;

use dmyers\validate\abstract\ValidationRuleAbstract;
use dmyers\validate\interfaces\ValidationRuleInterface;

class Differs extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $field, string $options = ''): bool
    {
        $this->errorString = '%s must differ from %s.';

        return !(isset($this->fieldsData[$options]) && $this->fieldsData[$options] === $field);
    }
}
