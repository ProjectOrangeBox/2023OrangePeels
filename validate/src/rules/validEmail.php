<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validEmail extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		if (!is_scalar($input) || count(explode('@', $input)) !== 2) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		if (function_exists('idn_to_ascii') && $atpos = strpos($input, '@')) {
			$input = substr($input, 0, ++$atpos) . idn_to_ascii(substr($input, $atpos));
		}

		return (bool) filter_var($input, FILTER_VALIDATE_EMAIL);
	}
}
