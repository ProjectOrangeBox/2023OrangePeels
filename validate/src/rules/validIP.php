<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;
use peel\validate\interfaces\ValidationRuleInterface;

class validIP extends ValidationRuleAbstract implements ValidationRuleInterface
{
	public function isValid(mixed $input, string $options = ''): void
	{
		$this->errorString = '%s may only contain alpha characters, spaces, and dashes.';

		if (!is_scalar($input)) {
			throw new ValidationFailed('%s may only contain hex characters a-f0-9');
		}

		$which = FILTER_FLAG_IPV4;

		switch (strtolower($options)) {
			case 'ipv4':
				$which = FILTER_FLAG_IPV4;
				break;
			case 'ipv6':
				$which = FILTER_FLAG_IPV6;
				break;
			case 'noPrivRange':
				$which = FILTER_FLAG_NO_PRIV_RANGE;
				break;
			case 'noResRange':
				$which = FILTER_FLAG_NO_RES_RANGE;
				break;
			case 'globalRange':
				$which = FILTER_FLAG_GLOBAL_RANGE;
				break;
		}

		return (bool) filter_var((string)$input, FILTER_VALIDATE_IP, $which);
	}
}
