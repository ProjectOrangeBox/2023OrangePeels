<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validJson extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		if (!is_scalar($input)) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		$input = (string)$input;

		if (substr($input, 0, 1) != '{' && substr($input, -1) != '}') {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		json_decode($input);

		return (json_last_error() === JSON_ERROR_NONE);
	}
}
