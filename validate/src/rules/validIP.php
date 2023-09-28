<?php

declare(strict_types=1);

namespace peel\validate\rules;

use peel\validate\exceptions\ValidationFailed;
use peel\validate\abstract\ValidationRuleAbstract;


class validIP extends ValidationRuleAbstract
{
    public function isValid(string $options = ''): void
    {
        $this->isStringNumber($input);

        $flag = FILTER_FLAG_IPV4;

        switch (strtolower($options)) {
            case 'ipv4':
                $flag = FILTER_FLAG_IPV4;
                break;
            case 'ipv6':
                $flag = FILTER_FLAG_IPV6;
                break;
            case 'noPrivRange':
                $flag = FILTER_FLAG_NO_PRIV_RANGE;
                break;
            case 'noResRange':
                $flag = FILTER_FLAG_NO_RES_RANGE;
                break;
            case 'globalRange':
                $flag = FILTER_FLAG_GLOBAL_RANGE;
                break;
        }

        if (filter_var($input, FILTER_VALIDATE_IP, $flag) === false) {
            throw new ValidationFailed('%s is not a valid ip address.');
        }
    }
}
