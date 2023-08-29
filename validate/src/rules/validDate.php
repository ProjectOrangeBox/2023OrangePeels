<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validDate extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		if (!is_scalar($input)) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		if (empty($options)) {
			return (strtotime($input) !== false);
		}

		$date   = DateTime::createFromFormat($options, $input);
		$errors = DateTime::getLastErrors();

		if ($date === false) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		// PHP 8.2 or later.
		if ($errors === false) {
			return true;
		}

		return $errors['warning_count'] === 0 && $errors['error_count'] === 0;
	}
}
