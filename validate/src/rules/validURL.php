<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validURL extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		if (!is_scalar($input) || $input === '' || is_bool($input)) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		if (preg_match('/\A(?:([^:]*)\:)?\/\/(.+)\z/', $input, $matches)) {
			if (!in_array($matches[1], ['http', 'https'], true)) {
				throw new ValidationFailed('%s may only contain hex characters a-f0-9');
			}

			$input = $matches[2];
		}

		$input = 'http://' . $input;

		return filter_var($input, FILTER_VALIDATE_URL) !== false;
	}
}
