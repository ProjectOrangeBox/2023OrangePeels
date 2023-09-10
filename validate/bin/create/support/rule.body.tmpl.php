<?php

declare(strict_types=1);

use peel\validate\Validate;
use peel\validate\exceptions\ValidationFailed;

final class rule%%BASENAME%%Test extends \unitTestHelper
{
    protected $config;
    protected $validateParent;
    protected $%%LBASENAME%%;

    protected function setUp(): void
    {
        $this->config = [
            'isTrue' => [1, '1', 'y', 'on', 'yes', 't', 'true', true],
            'isFalse' => [0, '0', 'n', 'off', 'no', 'f', 'false', false],
        ];
        $this->validateParent = new Validate($this->config);
        $this->%%LBASENAME%% = new %%NAMESPACE%%($this->config,$this->validateParent);
    }

%%BODY%%
}
