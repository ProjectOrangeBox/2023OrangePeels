<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class required extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		// a valid object or bool value
		if (is_object($input) || is_bool($input)) {
			return true;
		}

		// a array with more than 1 entry
		if (is_array($input)) {
			return (count($input) > 0);
		}

		// something else?
		if (!is_scalar($input)) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		return (trim((string)$input) !== '');
	}
}
