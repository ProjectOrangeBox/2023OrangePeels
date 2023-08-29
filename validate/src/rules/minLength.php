<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class minLength extends ValidationRuleAbstract implements ValidationRuleInterface
{
    public function isValid(mixed $input, string $options = ''): void
    {
        $this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

        if (!is_scalar($input) || is_bool($input) || !is_numeric($options)) {
		throw new ValidationFailed('%s may only contain hex characters a-f0-9');
	}

	return ((int)$options <= strlen((string)$input));
    }
}
